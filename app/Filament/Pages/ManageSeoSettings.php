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

    protected static ?string $navigationLabel = 'SEO та Google Аналітика';

    protected static ?string $title = 'Налаштування SEO та Google Аналітики';

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
                Section::make('Google Сервіси (Аналітика та Search Console)')
                    ->description('Підключення Google Analytics 4 (GA4), Google Tag Manager (GTM) та верифікація сайту в Google Search Console.')
                    ->icon(Heroicon::OutlinedChartBar)
                    ->schema([
                        TextInput::make('google_analytics_id')
                            ->label('Google Analytics Measurement ID (GA4)')
                            ->placeholder('G-XXXXXXXXXX')
                            ->helperText('Ідентифікатор потоку даних GA4 (наприклад: G-ABC1234567). Автоматично генерує gtag.js.'),
                        TextInput::make('google_tag_manager_id')
                            ->label('Google Tag Manager ID (GTM)')
                            ->placeholder('GTM-XXXXXXX')
                            ->helperText('Ідентифікатор контейнера GTM (наприклад: GTM-ABC1234). Підключає скрипт у head та noscript у body.'),
                        TextInput::make('google_site_verification')
                            ->label('Google Site Verification (Search Console)')
                            ->placeholder('напр. abcdef1234567890...')
                            ->helperText('Код верифікації для пошукового мета-тегу google-site-verification.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Мета-теги пошукової оптимізації (SEO)')
                    ->description('Заголовки, описи сторінки для пошукових систем (UA та EN версії) та ключові слова.')
                    ->icon(Heroicon::OutlinedDocumentMagnifyingGlass)
                    ->schema([
                        TextInput::make('meta_title_ua')
                            ->label('Meta Title (Українська)')
                            ->placeholder('Modex - 3D Друк та Технічне Проектування')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('meta_description_ua')
                            ->label('Meta Description (Українська)')
                            ->rows(3)
                            ->placeholder('Фулстек інженерне проектування, параметричне 3D CAD моделювання...')
                            ->columnSpanFull(),
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
                            ->label('Ключові слова (Keywords)')
                            ->placeholder('3d print, 3d друк, інженерне проектування, solidworks, prototyping')
                            ->columnSpanFull(),
                    ]),

                Section::make('Соціальні мережі (OpenGraph) та Індексація')
                    ->description('Прев\'ю зображення для соцмереж (Facebook, Telegram, LinkedIn), канонічна адреса та robots meta.')
                    ->icon(Heroicon::OutlinedShare)
                    ->schema([
                        TextInput::make('og_image')
                            ->label('OpenGraph Image URL або шлях')
                            ->placeholder('/images/og-preview.jpg')
                            ->helperText('Зображення при публікації посилань у соцмережах та месенджерах.'),
                        TextInput::make('canonical_url')
                            ->label('Канонічний URL сайту')
                            ->placeholder('https://modexdesign.com')
                            ->url()
                            ->helperText('Базовий канонічний URL сайту для уникнення дублів сторінок.'),
                        Toggle::make('is_indexed')
                            ->label('Дозволити індексацію сайту пошуковими роботами Google (index, follow)')
                            ->helperText('Вимкніть лише якщо сайт на технічній паузі або тестуванні (noindex, nofollow).')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Користувацькі HTML / JS скрипти')
                    ->description('Довільні сторонні скрипти для вставки в секції <head> та в кінці <body>.')
                    ->icon(Heroicon::OutlinedCodeBracket)
                    ->schema([
                        Textarea::make('custom_head_scripts')
                            ->label('Скрипти в <head>')
                            ->placeholder('<!-- Додаткові коди ретаргетингу, пікселів Meta Facebook тощо -->')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('custom_body_scripts')
                            ->label('Скрипти перед закриттям </body>')
                            ->placeholder('<!-- Онлайн чати, віджети тощо -->')
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
                ->label('Зберегти налаштування')
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSetting::current()->update($data);

        Notification::make()
            ->title('Налаштування SEO та Google успішно збережено!')
            ->success()
            ->send();
    }
}
