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

class SendRequest extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];

    //...
    protected static ?string $navigationIcon = 'heroicon-s-chat-bubble-left';

    protected static string $view = 'filament.marketer.pages.sendRequest';
    protected static ?int $navigationSort = 5;

    public static function getNavigationLabel(): string
    {
        return __('Send Request');
    }

    public function getHeading(): string
    {
        return __('Send Request');
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('Send')
                ->label(__('Send'))
                ->color('primary')
                ->submit('Send'),
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
            ->title(__('Request Sent Successfully.'))
            ->success()
            ->send();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->label(__('Content'))
                            ->required(),
                    ])->columns(1),
            ])
            ->statePath('data')
            ->model(auth()->user());
    }
}
