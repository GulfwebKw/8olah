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
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static string $view = 'filament.marketer.pages.profile';
    protected static ?int $navigationSort = 10;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
    public static function getNavigationLabel(): string
    {
        return __('Profile');
    }

    public function getHeading(): string
    {
        return __('Profile');
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
                ->label(__('Update'))
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
            ->title(__('Profile updated!'))
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
                            ->label(__('Name'))
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('company_name')
                            ->label(__('Shop Name'))
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('username')
                            ->label(__('Username'))
                            ->maxLength(255)
                            ->unique(User::class , 'username' , null,true )
                            ->required(),
                        Forms\Components\FileUpload::make('avatar')
                            ->label(__('avatar'))
                            ->image()
                            ->imageEditor(),
                    ])->columns(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->label(__('bank_name'))
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('bank_number')
                            ->label(__('bank_number'))
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('bank_iban')
                            ->label(__('bank_iban'))
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('vodaphone')
                            ->label('Vodaphone Number')
                            ->maxLength(255)
                            ->required(),
                    ])->columns(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label(__('Password'))
                            ->nullable()
                            ->confirmed()
                            ->helperText(__('Set empty if you do not need change password!'))
                            ->type('password'),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label(__('Password Confirmation'))
                            ->nullable()
                            ->type('password'),
                    ])->columns(2),
            ])
            ->statePath('data')
            ->model(auth()->user());
    }
}
