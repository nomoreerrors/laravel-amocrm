<?php

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


class AmoCRMRepository extends BaseCRMRepository
{

    private $crm;

    
    public function __construct()
    {
        $this->crm = new AmoCrmConnectionModel();
        $this->crm->connect(new AmoCRMConfig());
    }


    /**
     * Подготовка поля value и отправка в AmoCRM
     * @param int $fieldId - id кастомного поля
     * @param int $value - желаемое значение кастомного поля
     * @param int $leadId - id сделки
     * @throws AmoCRMApiException
     */
    public function setCustomFieldsValue(int $fieldId, int $value, string $leadId)
    {
        $leadsService = $this->crm->apiClient->leads();
        $lead = new LeadModel();
        $leadCustomFieldsValues = new CustomFieldsValuesCollection();
        $textCustomFieldValueModel = new TextCustomFieldValuesModel();
        $textCustomFieldValueModel->setFieldId($fieldId);
     
      
        $textCustomFieldValueModel->setValues(
            (new TextCustomFieldValueCollection())
                ->add((new TextCustomFieldValueModel())->setValue($value))
        );
        $leadCustomFieldsValues->add($textCustomFieldValueModel);
        $lead->setCustomFieldsValues($leadCustomFieldsValues);
        $lead->setId($leadId);


        try {
            $lead = $leadsService->updateOne($lead);
            Log::info('Отправил lead');
        } catch (AmoCRMApiException $e) {
            dd($e);
            die;
        }
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
            exit('Invalid access token ' . var_export($accessToken, true));
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
            Log::error('Некоторые поля Access token отсутствуют');
            return false;
        }
    }
}