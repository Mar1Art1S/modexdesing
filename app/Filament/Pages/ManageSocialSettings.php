<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageSocialSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $navigationLabel = 'Соцмережі та Контакти';

    protected static ?string $title = 'Посилання на Соціальні мережі та Контакти';

    protected static ?int $navigationSort = 11;

    protected string $view = 'filament.pages.manage-social-settings';

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
                Section::make('Месенджери та Соціальні мережі')
                    ->description('Посилання на підключені канали зв\'язку. Вони відображаються у плаваючому віджеті швидкого зв\'язку, у підвалі (футері) сайту та у блоці прямого контакту.')
                    ->icon(Heroicon::OutlinedShare)
                    ->schema([
                        TextInput::make('instagram_url')
                            ->label('Instagram URL')
                            ->placeholder('https://instagram.com/modexdesign')
                            ->url()
                            ->helperText('Посилання на профіль Instagram (плаваючий віджет, футер та блок контактів).'),

                        TextInput::make('facebook_url')
                            ->label('Facebook URL')
                            ->placeholder('https://facebook.com/modexdesign')
                            ->url()
                            ->helperText('Посилання на сторінку Facebook (плаваючий віджет, футер та блок контактів).'),

                        TextInput::make('whatsapp_url')
                            ->label('WhatsApp URL')
                            ->placeholder('https://wa.me/380970000000')
                            ->url()
                            ->helperText('Пряме посилання на чат WhatsApp (наприклад: https://wa.me/380XXXXXXXXX).'),

                        TextInput::make('telegram_url')
                            ->label('Telegram URL')
                            ->placeholder('https://t.me/modexdesign')
                            ->url()
                            ->helperText('Посилання на Telegram профіль або канал (наприклад: https://t.me/...).'),

                        TextInput::make('viber_url')
                            ->label('Viber URL / номер')
                            ->placeholder('viber://chat?number=%2B380970000000')
                            ->helperText('Посилання на Viber або номер для прямого дзвінка/чату.'),
                    ])
                    ->columns(2),

                Section::make('Прямі контакти майстерні')
                    ->description('Email та номер телефону для прийому технічних запитів та файлів CAD моделей.')
                    ->icon(Heroicon::OutlinedEnvelope)
                    ->schema([
                        TextInput::make('contact_email')
                            ->label('Контактний Email')
                            ->email()
                            ->placeholder('orders@modexdesign.com')
                            ->helperText('Офіційний email для замовлень та консультацій.'),

                        TextInput::make('contact_phone')
                            ->label('Контактний телефон')
                            ->tel()
                            ->placeholder('+380 97 000 00 00')
                            ->helperText('Номер телефону для швидкого зв\'язку з інженером.'),
                    ])
                    ->columns(2),
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
                ->label('Зберегти посилання')
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSetting::current()->update($data);

        Notification::make()
            ->title('Посилання на соцмережі та контакти успішно збережено!')
            ->success()
            ->send();
    }
}
