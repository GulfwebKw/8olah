<?php

namespace App\Filament\Marketer\Pages;

use App\Jobs\SendInboxEmailJob;
use App\Models\CheckoutType;
use App\Models\Inbox;
use App\Models\RequestType;
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
        $user = auth()->user();
        $inbox = Inbox::query()->create([
            'user_id' => auth()->id(),
            'message' => $data['content'],
            'seen' => 0,
            'vodaphone' => optional($data)['vodaphone'] ?? '',
            'type_id' => $data['type_id'],
            'checkOut_id' => $data['checkOut_id'],
        ]);
        if ( $user->vodaphone != $data['vodaphone']) {
            $user->vodaphone = $data['vodaphone'];
            $user->save();
        }
        $this->form->fill(['content' => '' , 'type_id' => null , 'vodaphone' => $user->vodaphone, 'checkOut_id' => null]);
        Notification::make()
            ->title(__('Request Sent Successfully.'))
            ->success()
            ->send();
        dispatch(new SendInboxEmailJob($inbox->id));
    }

    public function mount(): void
    {
        $this->form->fill([
            'vodaphone' => auth()->user()->vodaphone
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('checkOut_id')
                            ->label(__('checkout_type'))
                            ->options(CheckoutType::query()
                                ->orderBy('title')
                                ->get()->pluck( 'title' , 'id')
                            )->required(),
                        Forms\Components\TextInput::make('vodaphone')
                            ->label(__('Vodaphone Number'))
                            ->nullable(),
                        Forms\Components\Select::make('type_id')
                            ->label(__('Type'))
                            ->options(RequestType::query()
                                ->orderBy('title_'.app()->getLocale())
                                ->get()->pluck( 'title_'.app()->getLocale() , 'id')
                            )->required(),
                        Forms\Components\Textarea::make('content')
                            ->label(__('Content'))
                            ->rows(7)
                            ->columnSpan(2)
                            ->required(),
                    ])->columns(2),
            ])
            ->statePath('data')
            ->model(auth()->user());
    }
}
