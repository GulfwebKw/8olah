<?php

namespace App\Filament\Marketer\Pages;

use App\Models\Inbox;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions;

/**
 * @property \Filament\Forms\Form $form;
 */
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
            Actions\Action::make('SendRequest')
                ->label(__('Send'))
                ->color('primary')
                ->submit('SendRequest'),
        ];
    }

    public function SendRequest(): void
    {
        $data = $this->form->getState();
        Inbox::query()->create([
            'user_id' => auth()->id(),
            'message' => $data['content'],
            'seen' => 0,
        ]);
        $this->form->fill(['content' => '']);
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
                        Forms\Components\Textarea::make('content')
                            ->label(__('Content'))
                            ->rows(7)
                            ->required(),
                    ])->columns(1),
            ])
            ->statePath('data')
            ->model(auth()->user());
    }
}
