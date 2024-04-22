<?php

namespace App\Models;

use App\Filament\Resources\Panel\IntroduceResource\Widgets\APIOverview;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * @property int $id
 * @property Carbon $created
 */
class IntroduceApi extends Model
{
    use \Sushi\Sushi;

    /**
     * Model Rows
     */
    public function getRows()
    {
        try {
            $client = new Client(['verify' => false ]);
            $res = $client->request('POST', 'https://8olah.com/client/jobs.php', [
                'form_params' => [
                    'mobile' => APIOverview::$customer_phone
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
}
