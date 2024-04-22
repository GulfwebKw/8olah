<?php

namespace App\Filament\Resources\Panel\IntroduceResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Webbingbrasil\FilamentAdvancedFilter\Filters\DateFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\TextFilter;
use Illuminate\Database\Eloquent\Model;
class APIOverview extends BaseWidget
{
    public ?Model $record = null;

    protected function getFormSchema(): array
    {
        try {
            $client = new Client();
            $res = $client->request('POST', 'https://8olah.com/client/jobs.php', [
                'form_params' => [
                    'mobile' => $this->record?->customer_phone
                ]
            ]);
            if ($res->getStatusCode() == 200) {
                $result = $res->getBody()->getContents();
                $data = json_decode($result, true);
                if ($data['status'] == 200) {
                    return $data['data']['jobs'];
                }
            }
        } catch (ClientException|GuzzleException $e) {}
        return [];
    }
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('total_jobs')
                    ->label('Number Works')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created')
                    ->label('Created At')
                    ->sortable(),
            ])
            ->filters([
                DateFilter::make('created'),
            ])->defaultSort('created','desc');
    }
}
