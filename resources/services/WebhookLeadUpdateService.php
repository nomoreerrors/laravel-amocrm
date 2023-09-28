<?php

namespace Resources\Services;

use Resources\Services\BaseWebhookService;
use Exception;
use Illuminate\Support\Arr;
use App\Http\classes\AmoCRMConfig;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use AmoCRM\Models\LeadModel;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Exceptions\AmoCRMApiException;
use App\Models\AmoCRM\AmoCrmConnectionModel;

/**
 * Обработка полей полученных с webhook данных 
 */
class WebhookLeadUpdateService extends BaseWebhookService
{   
    /**
     * Полученные данные с webhook.
     * @var array
     */
    private array $data;


    
    public function __construct(array $data)
    {
        $this->data = $data;
    }



    /**
     * Возвращает всё поле - custom_fields или один из его объектов по id.
     *  @throws Exception
     */
    public function getCustomFields()
    {   
        $result = Arr::get($this->data, 'leads.update.0.custom_fields');
        return $result;

    }
    

    /**
     * Возвращает поле update или один из его объектов.
     * @throws Exception
     */
    public function getUpdate(?string $key = null): array | string
    {
        if(!$key) {
            $result = Arr::get($this->data, 'leads.update' );
            return $result;
        }
        if($key) {
            $result = Arr::get($this->data, 'leads.update.0.'.$key );
            return $result;
        };
       

    }

    
    /**
     * Возвращает поле leads из webhook object
     */
    public function getLeads(): array 
    {       
           $result = Arr::get($this->data, 'leads');
           return $result;
    }




    /**
     * Возвращает поле webhook - account.
     */
    public function getAccount(?string $key = ''): string | array
    {
       if(!$key) {
           $result = Arr::get($this->data, 'account');
           return $result;
       }
       else {
           $result = Arr::get($this->data, 'account.'.$key);
           return $result;
       }

    }

    

    /**
     * Возвращает значение custom_fields value объекта webhook
     * @throws Exception
     * @return string
     */
    public function getCustomFieldsValues(int $id): array
    {
        $c = Arr::get($this->data, 'leads.update.0.custom_fields');

        foreach($c as $obj) {
            if($obj['id'] == $id) {
                return $obj['values'];
            }
        }
    }



    public function updateProfitField(object $updateData): void
    {
        $crm = new AmoCrmConnectionModel();
        $crm->connect(new AmoCRMConfig());


        $leadsService = $crm->apiClient->leads();
        $lead = new LeadModel();
        $leadCustomFieldsValues = new CustomFieldsValuesCollection();
        $textCustomFieldValueModel = new TextCustomFieldValuesModel();
        $textCustomFieldValueModel->setFieldId($updateData->profitFieldId);
     
      
        $textCustomFieldValueModel->setValues(
            (new TextCustomFieldValueCollection())
                ->add((new TextCustomFieldValueModel())->setValue($updateData->profit))
        );
        $leadCustomFieldsValues->add($textCustomFieldValueModel);
        $lead->setCustomFieldsValues($leadCustomFieldsValues);
        $lead->setId($updateData->updateId);


        
      


        try {
            $lead = $leadsService->updateOne($lead);
x
        } catch (AmoCRMApiException $e) {
            dd($e);
            die;
        }


    }



}