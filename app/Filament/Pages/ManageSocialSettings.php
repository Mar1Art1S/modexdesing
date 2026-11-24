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

    protected static ?string $navigationLabel = 'Social & Contacts';

    protected static ?string $title = 'Social Media Links & Contacts';

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
                Section::make('Messengers & Social Media')
                    ->description('Links to connected contact channels shown in floating contact widgets, footer, and direct contact sections.')
                    ->icon(Heroicon::OutlinedShare)
                    ->schema([
                        TextInput::make('instagram_url')
                            ->label('Instagram URL')
                            ->placeholder('https://instagram.com/modexdesign')
                            ->url()
                            ->helperText('Instagram profile link.'),

                        TextInput::make('facebook_url')
                            ->label('Facebook URL')
                            ->placeholder('https://facebook.com/modexdesign')
                            ->url()
                            ->helperText('Facebook page link.'),

                        TextInput::make('whatsapp_url')
                            ->label('WhatsApp URL')
                            ->placeholder('https://wa.me/10000000000')
                            ->url()
                            ->helperText('Direct WhatsApp chat link (e.g., https://wa.me/...).'),

                        TextInput::make('telegram_url')
                            ->label('Telegram URL')
                            ->placeholder('https://t.me/modexdesign')
                            ->url()
                            ->helperText('Telegram link.'),

                        TextInput::make('viber_url')
                            ->label('Viber URL / Phone')
                            ->placeholder('viber://chat?number=%2B10000000000')
                            ->helperText('Viber link or number for direct messaging.'),
                    ])
                    ->columns(2),

                Section::make('Workshop Direct Contacts')
                    ->description('Email and telephone number for technical inquiries and 3D CAD models.')
                    ->icon(Heroicon::OutlinedEnvelope)
                    ->schema([
                        TextInput::make('contact_email')
                            ->label('Contact Email')
                            ->email()
                            ->placeholder('orders@modexdesign.com')
                            ->helperText('Official email for orders and consultations.'),

                        TextInput::make('contact_phone')
                            ->label('Contact Phone')
                            ->tel()
                            ->placeholder('+1 (555) 000-0000')
                            ->helperText('Phone number for rapid communication with engineering.'),
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
                ->label('Save Links')
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSetting::current()->update($data);

        Notification::make()
            ->title('Social links and contact info saved successfully!')
            ->success()
            ->send();
    }
}
