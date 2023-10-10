<?php

declare(strict_types=1);

namespace App\Http\classes;

use App\Models\AmoCRM\AmoCrmConnectionModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Exceptions\AmoCRMApiException;
use Illuminate\Support\Facades\Storage;
use League\OAuth2\Client\Token\AccessToken;
use Illuminate\Support\Facades\Log;
use App\Http\classes\BaseCRMRepository;
use Exception;

class AmoCRMRepository extends BaseCRMRepository
{

    private $crm;

    
    public function __construct()
    {
        $this->crm = new AmoCrmConnectionModel();
        $this->crm->connect(new AmoCRMConfig());
    }


    /**
     * @param int $fieldId - id кастомного поля
     * @param int $data - желаемое значение кастомного поля (value)
     * @throws AmoCRMApiException
     */
    public function createCustomFieldsTextValue(int $fieldId, string $data)
    {

            $value = (new TextCustomFieldValueModel())
                                        ->setValue($data);

            $valueCollection =  (new TextCustomFieldValueCollection())
                                        ->add($value);

            $valuesModel = (new TextCustomFieldValuesModel())
                                        ->setFieldId($fieldId)
                                        ->setValues($valueCollection);
                        
            $valuesCollection = (new CustomFieldsValuesCollection())
                                        ->add($valuesModel);

            return $valuesCollection;
    }



    /**
     * Save token to Laravel storage
     */
    public static function saveTokenToStorage(AccessToken $accessToken, string $baseDomain): void
    {
        if (
            $accessToken->getToken() &&
            $accessToken->getRefreshToken() &&
            $accessToken->getExpires() &&
            $baseDomain
        ) {
            Storage::put('access_token.txt', json_encode(
                [
                    'accessToken' => $accessToken->getToken(),
                    'refreshToken' => $accessToken->getRefreshToken(),
                    'expires' => $accessToken->getExpires(),
                    'baseDomain' => $baseDomain
                ]
                ));

            
        } else {
            exit('Одно или несколько полей access token отсутствуют ' . var_export($accessToken, true));
        }
        
    }


    /**
     * Get token from Laravel storage
     */

    public static function getTokenFromStorage(): AccessToken | bool
    {
        if (!Storage::get('access_token.txt')) {
            Log::error('Access token не найден');
            return false;
        }

        $accessToken = json_decode(Storage::get('access_token.txt'), true);

        if (
            isset($accessToken)
            && isset($accessToken['accessToken'])
            && isset($accessToken['refreshToken'])
            && isset($accessToken['expires'])
            && isset($accessToken['baseDomain'])
        ) {
            return new AccessToken([
                'access_token' => $accessToken['accessToken'],
                'refresh_token' => $accessToken['refreshToken'],
                'expires' => $accessToken['expires'],
                'baseDomain' => $accessToken['baseDomain'],
            ]);
            
        } 
        else {
            info('Одно или несколько полей access token отсутствуют ' . var_export($accessToken, true));
            return false;
        }
    }


    public function updateLead(LeadModel $lead): void
    {
        try {
            $leadsService = $this->crm->apiClient->leads();
            $leadsService->updateOne($lead);
            info('Отправил lead. id: '.$lead->getId);
            

        } catch (AmoCRMApiException $e) {
            if($e->getErrorCode() == 400) {
                info('Код ошибки 400. Вероятно, попытка обновить несуществующую сделку. id: '.$lead->getId(),
                [$e->getDescription(), $e->getMessage()]);
            }
            else {
                info($e->getMessage(), [$e->getDescription(), __CLASS__, __LINE__]);
            }
        }
    }


}