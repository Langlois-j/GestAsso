<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembreResource\Pages;
use App\Models\Membre;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MembreResource extends Resource
{
    protected static ?string $model = Membre::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Membres';

    protected static ?string $modelLabel = 'Membre';

    protected static ?string $pluralModelLabel = 'Membres';

    protected static ?string $navigationGroup = 'Club';

    protected static ?int $navigationSort = 1;

    // =========================================================================
    // FORM
    // =========================================================================

    public static function form(Form $form): Form
    {
        $isPresident  = auth()->user()?->hasRole('president');
        $isEncadrant  = auth()->user()?->hasAnyRole(['president', 'encadrant']);

        return $form->schema([

            // -----------------------------------------------------------------
            // Section 1 — Identité
            // -----------------------------------------------------------------
            Section::make('Identité')
                ->description('Informations personnelles du membre.')
                ->icon('heroicon-o-identification')
                ->columns(2)
                ->schema([

                    TextInput::make('nom')
                        ->label('Nom')
                        ->required()
                        ->maxLength(100)
                        ->columnSpan(1),

                    TextInput::make('prenom')
                        ->label('Prénom')
                        ->required()
                        ->maxLength(100)
                        ->columnSpan(1),

                    DatePicker::make('date_naissance')
                        ->label('Date de naissance')
                        ->required()
                        ->maxDate(now())
                        ->live()
                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                            // S1-10 — calcul isMineur en temps réel dans le form
                        })
                        ->helperText(fn ($state) => $state && Carbon::parse($state)->age < 18
                            ? '👶 Mineur — Responsables légaux et AST requis.'
                            : null)
                        ->columnSpan(1),

                    // Badge visuel mineur — lecture seule
                    Placeholder::make('statut_age')
                        ->label('Statut')
                        ->content(fn ($record) => $record?->is_mineur
                            ? '👶 Mineur'
                            : '🧑 Majeur')
                        ->visible(fn ($record) => $record !== null)
                        ->columnSpan(1),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->helperText('Identifiant de connexion.')
                        ->columnSpan(1),

                    TextInput::make('telephone')
                        ->label('Téléphone')
                        ->tel()
                        ->columnSpan(1),

                    Textarea::make('adresse')
                        ->label('Adresse postale')
                        ->rows(2)
                        ->columnSpan(2),

                    FileUpload::make('photo')
                        ->label('Photo')
                        ->image()
                        ->imageResizeTargetWidth(400)
                        ->imageResizeTargetHeight(400)
                        ->directory('membres/photos')
                        ->columnSpan(2),
                ]),

            // -----------------------------------------------------------------
            // Section 2 — Rôles
            // -----------------------------------------------------------------
            Section::make('Rôles dans le club')
                ->icon('heroicon-o-shield-check')
                ->description('Les droits accordés sont l\'union de tous les rôles actifs.')
                ->schema([

                    Select::make('roles')
                        ->label('Rôle(s)')
                        ->multiple()
                        ->relationship('roles', 'name')
                        ->options([
                            'president'       => 'Président',
                            'encadrant'       => 'Encadrant',
                            'gestionnaire_epi'=> 'Gestionnaire EPI',
                            'membre'          => 'Membre',
                            'responsable_legal'=> 'Responsable légal',
                        ])
                        ->preload()
                        ->helperText('Rôles cumulables — les droits s\'additionnent.'),
                ]),

            // -----------------------------------------------------------------
            // Section 3 — Licence FFME (P3 — MEMB-M11)
            // -----------------------------------------------------------------
            Section::make('Licence FFME')
                ->icon('heroicon-o-identification')
                ->description('La RC est incluse dans la cotisation FFME. GestionAsso vérifie uniquement la validité de la licence.')
                ->columns(2)
                ->schema([

                    TextInput::make('n_licence_ffme')
                        ->label('N° de licence FFME')
                        ->required()
                        ->helperText('Champ obligatoire et bloquant.')
                        ->suffixIcon('heroicon-o-check-badge')
                        ->columnSpan(1),

                    Select::make('saison_validite_licence')
                        ->label('Saison de validité')
                        ->options(static::optionsSaisons())
                        ->default(Membre::saisonCourante())
                        ->required()
                        ->columnSpan(1),

                    Toggle::make('licence_verifiee')
                        ->label('Licence vérifiée via API FFME')
                        ->helperText('Mis à jour automatiquement par FfmeApiService (S1-07). Saisie manuelle = fallback.')
                        ->disabled(fn () => !$isPresident)
                        ->columnSpan(2),
                ]),

            // -----------------------------------------------------------------
            // Section 4 — Passeport FFME (P11 — MEMB-M16)
            // -----------------------------------------------------------------
            Section::make('Passeport FFME')
                ->icon('heroicon-o-trophy')
                ->description('Le passeport est un acquis permanent — il n\'expire pas. Donnée absente → 🔴 par défaut.')
                ->columns(2)
                ->schema([

                    Select::make('couleur_passeport')
                        ->label('Couleur du passeport')
                        ->options([
                            'rouge'  => '🔴 Encadrement obligatoire (< Jaune)',
                            'jaune'  => '🟡 Bloc SAE + moulinette',
                            'orange' => '🟠 SAE complète',
                            'vert'   => '🟢 SNE encadrée',
                            'bleu'   => '🔵 SNE 1 longueur',
                            'violet' => '🟣 SNE plusieurs longueurs',
                        ])
                        ->default('rouge')
                        ->helperText('Source : API FFME. Fallback : validation bureau.')
                        // L-01 : flag RGPD — base légale affichage donnée référentiel FFME tiers
                        ->columnSpan(1),

                    DatePicker::make('date_validation_passeport')
                        ->label('Date de validation')
                        ->maxDate(now())
                        ->columnSpan(1),

                    Select::make('validateur_passeport_id')
                        ->label('Validateur')
                        ->relationship('validateurPasseport', 'nom')
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->nom_complet)
                        ->searchable()
                        ->helperText('Membre du bureau ou API FFME.')
                        ->columnSpan(2),
                ]),

            // -----------------------------------------------------------------
            // Section 5 — Informations internes (Président + Encadrant seulement)
            // -----------------------------------------------------------------
            Section::make('Informations internes')
                ->icon('heroicon-o-lock-closed')
                ->description('Visible uniquement par le Président et les Encadrants.')
                ->visible($isEncadrant)
                ->schema([

                    Textarea::make('commentaire_interne')
                        ->label('Commentaire interne')
                        ->rows(3)
                        ->helperText('Non visible par le membre concerné.'),
                ]),

        ]);
    }

    // =========================================================================
    // TABLE
    // =========================================================================

    public static function table(Table $table): Table
    {
        $isEncadrant = auth()->user()?->hasAnyRole(['president', 'encadrant']);

        return $table
            ->columns([

                ImageColumn::make('photo')
                    ->label('')
                    ->circular()
                    ->width(40)
                    ->height(40),

                TextColumn::make('nom_complet')
                    ->label('Nom')
                    ->searchable(['nom', 'prenom'])
                    ->sortable(['nom'])
                    ->weight('semibold'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                BadgeColumn::make('statut_age')
                    ->label('Âge')
                    ->getStateUsing(fn ($record) => $record->is_mineur ? 'Mineur' : 'Majeur')
                    ->colors([
                        'warning' => 'Mineur',
                        'success' => 'Majeur',
                    ]),

                // Icône autonomie — visible encadrants+ seulement (L-01)
                TextColumn::make('icone_autonomie')
                    ->label('Autonomie')
                    ->visible($isEncadrant)
                    ->tooltip(fn ($record) => match ($record->couleur_passeport) {
                        'jaune'  => 'Bloc SAE + moulinette',
                        'orange' => 'SAE complète',
                        'vert'   => 'SNE encadrée',
                        'bleu'   => 'SNE 1 longueur',
                        'violet' => 'SNE plusieurs longueurs',
                        default  => 'Encadrement obligatoire',
                    }),

                BadgeColumn::make('saison_validite_licence')
                    ->label('Saison licence')
                    ->colors([
                        'success' => fn ($state) => $state === Membre::saisonCourante(),
                        'danger'  => fn ($state) => $state !== Membre::saisonCourante(),
                    ]),

                IconColumn::make('licence_verifiee')
                    ->label('Licence API')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-exclamation-circle')
                    ->trueColor('success')
                    ->falseColor('warning'),

            ])
            ->filters([

                TernaryFilter::make('is_mineur')
                    ->label('Âge')
                    ->trueLabel('Mineurs')
                    ->falseLabel('Majeurs')
                    ->queries(
                        true:  fn (Builder $q) => $q->mineurs(),
                        false: fn (Builder $q) => $q->majeurs(),
                    ),

                SelectFilter::make('couleur_passeport')
                    ->label('Passeport')
                    ->options([
                        'rouge'  => '🔴 Encadrement obligatoire',
                        'jaune'  => '🟡 Jaune',
                        'orange' => '🟠 Orange',
                        'vert'   => '🟢 Vert',
                        'bleu'   => '🔵 Bleu',
                        'violet' => '🟣 Violet',
                    ]),

                SelectFilter::make('saison_validite_licence')
                    ->label('Saison licence')
                    ->options(static::optionsSaisons()),

                TernaryFilter::make('licence_verifiee')
                    ->label('Licence vérifiée API'),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->hasRole('president')),
                ]),
            ])
            ->defaultSort('nom');
    }

    // =========================================================================
    // PAGES
    // =========================================================================

    public static function getRelationManagers(): array
    {
        return [
            // S1-14 : MembreResource\RelationManagers\ResponsablesLegauxRelationManager::class,
            // S2-02 : MembreResource\RelationManagers\DiplomesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMembres::route('/'),
            'create' => Pages\CreateMembre::route('/create'),
            'view'   => Pages\ViewMembre::route('/{record}'),
            'edit'   => Pages\EditMembre::route('/{record}/edit'),
        ];
    }

    // =========================================================================
    // HELPERS
    // =========================================================================

    /**
     * Génère les options de saisons FFME (saison courante + 2 précédentes).
     */
    private static function optionsSaisons(): array
    {
        $now  = Carbon::now();
        $year = $now->month >= 9 ? $now->year : $now->year - 1;

        $saisons = [];
        for ($i = 0; $i <= 2; $i++) {
            $y = $year - $i;
            $key = $y . '-' . ($y + 1);
            $saisons[$key] = $key;
        }
        return $saisons;
    }
}