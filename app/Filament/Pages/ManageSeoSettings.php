<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageSeoSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static ?string $navigationLabel = 'SEO & Google Analytics';

    protected static ?string $title = 'SEO & Google Analytics Settings';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.manage-seo-settings';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->attributesToArray());
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Google Services (Analytics & Search Console)')
                    ->description('Connect Google Analytics 4 (GA4), Google Tag Manager (GTM), and Google Search Console site verification.')
                    ->icon(Heroicon::OutlinedChartBar)
                    ->schema([
                        TextInput::make('google_analytics_id')
                            ->label('Google Analytics Measurement ID (GA4)')
                            ->placeholder('G-XXXXXXXXXX')
                            ->helperText('GA4 stream measurement ID (e.g., G-ABC1234567). Automatically generates gtag.js.'),
                        TextInput::make('google_tag_manager_id')
                            ->label('Google Tag Manager ID (GTM)')
                            ->placeholder('GTM-XXXXXXX')
                            ->helperText('GTM container ID (e.g., GTM-ABC1234). Adds head script and body noscript.'),
                        TextInput::make('google_site_verification')
                            ->label('Google Site Verification (Search Console)')
                            ->placeholder('e.g. abcdef1234567890...')
                            ->helperText('Verification code for google-site-verification meta tag.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Search Engine Optimization Meta Tags (SEO)')
                    ->description('Page titles, descriptions for search engines, and targeted keywords.')
                    ->icon(Heroicon::OutlinedDocumentMagnifyingGlass)
                    ->schema([
                        TextInput::make('meta_title_en')
                            ->label('Meta Title (English)')
                            ->placeholder('Modex - Full-Stack 3D Printing & Technical Hardware Engineering')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('meta_description_en')
                            ->label('Meta Description (English)')
                            ->rows(3)
                            ->placeholder('From concept to physical reality: Full-Stack Hardware Engineering...')
                            ->columnSpanFull(),
                        TextInput::make('meta_keywords')
                            ->label('Keywords')
                            ->placeholder('3d print, 3d printing, mechanical engineering, solidworks, prototyping')
                            ->columnSpanFull(),
                    ]),

                Section::make('Social Media (OpenGraph) & Indexing')
                    ->description('Social media preview image (Facebook, Telegram, LinkedIn), canonical URL, and search bot directives.')
                    ->icon(Heroicon::OutlinedShare)
                    ->schema([
                        TextInput::make('og_image')
                            ->label('OpenGraph Image URL or Path')
                            ->placeholder('/images/og-preview.jpg')
                            ->helperText('Image shown when sharing links on social media and messaging apps.'),
                        TextInput::make('canonical_url')
                            ->label('Canonical Site URL')
                            ->placeholder('https://modexdesign.com')
                            ->url()
                            ->helperText('Base canonical URL to prevent duplicate content.'),
                        Toggle::make('is_indexed')
                            ->label('Allow indexing by search engines (index, follow)')
                            ->helperText('Disable only during maintenance or testing (noindex, nofollow).')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Custom HTML / JS Scripts')
                    ->description('Arbitrary scripts injected into the <head> section or at the end of <body>.')
                    ->icon(Heroicon::OutlinedCodeBracket)
                    ->schema([
                        Textarea::make('custom_head_scripts')
                            ->label('Scripts in <head>')
                            ->placeholder('<!-- Additional retargeting codes, Meta Facebook pixel, etc. -->')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('custom_body_scripts')
                            ->label('Scripts before </body>')
                            ->placeholder('<!-- Live chat widgets, tracking scripts, etc. -->')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
            ]);
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make($this->getFormActions()),
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSetting::current()->update($data);

        Notification::make()
            ->title('SEO and Google settings saved successfully!')
            ->success()
            ->send();
    }
}
