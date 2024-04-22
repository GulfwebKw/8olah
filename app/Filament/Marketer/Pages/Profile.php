<?php

namespace App\Filament\Marketer\Pages;

use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];

    //...
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.marketer.pages.profile';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function mount(): void
    {
        $this->form->fill(
            auth()->user()->attributesToArray()
        );
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('Update')
                ->color('primary')
                ->submit('Update'),
        ];
    }

    public function update()
    {
        $data = $this->form->getState();
        if ( $data['password'] ) {
            $data['password'] = bcrypt($data['password']);
            unset($data['password_confirmation']);
        } else {
            unset($data['password_confirmation'],$data['password']);
        }
        auth()->user()->update($data);

        Notification::make()
            ->title('Profile updated!')
            ->success()
            ->send();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('company_name')
                            ->label(__('Shop Name'))
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('username')
                            ->maxLength(255)
                            ->unique(User::class , 'username' , null,true )
                            ->required(),
                        Forms\Components\FileUpload::make('avatar')
                            ->image()
                            ->imageEditor(),
                    ])->columns(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('bank_number')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('bank_iban')
                            ->maxLength(255)
                            ->required(),
                    ])->columns(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->nullable()
                            ->confirmed()
                            ->helperText("Set empty if you do not need change password!")
                            ->type('password'),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->nullable()
                            ->type('password'),
                    ])->columns(2),
            ])
            ->statePath('data')
            ->model(auth()->user());
    }
}
