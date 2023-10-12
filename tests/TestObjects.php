<?php 

namespace Tests;

class TestObjects
{
    private string $noValues = '{"account":{"subdomain":"nomoreerrors","id":"31310398","_links":{"self":"https:\/\/nomoreerrors.amocrm.ru"}},"leads":{"update":[{"id":"39976531","name":"\u041f\u043e\u043a\u0443\u043f\u043a\u0430 \u043f\u0440\u044f\u043d\u0438\u043a\u043e\u0432","status_id":"60650182","price":"15000","responsible_user_id":"10121570","last_modified":"1696340287","modified_user_id":"10121570","created_user_id":"10121570","date_create":"1696340287","pipeline_id":"7277538","account_id":"31310398","created_at":"1696340287","updated_at":"1696340287"}]},"state":"08269884f9a9a4b8a7c16644221vvfda58bdd6a3"}';
    private string $withValues = '{"account":{"subdomain":"nomoreerrors","id":"31310398","_links":{"self":"https:\/\/nomoreerrors.amocrm.ru"}},"leads":{"update":[{"id":"39958589","name":"\u041f\u043e\u043a\u0443\u043f\u043a\u0430 \u0433\u0440\u0438\u0431\u043e\u0432","status_id":"60650182","price":"200000","responsible_user_id":"10121570","last_modified":"1696330619","modified_user_id":"10121570","created_user_id":"10121570","date_create":"1696330619","pipeline_id":"7277538","tags":[{"id":"812623","name":"\u0438\u043c\u043f\u043e\u0440\u0442_03102023_1356"}],"account_id":"31310398","custom_fields":[{"id":"2505835","name":"\u0421\u0435\u0431\u0435\u0441\u0442\u043e\u0438\u043c\u043e\u0441\u0442\u044c","values":[{"value":"100000"}]}],"created_at":"1696330619","updated_at":"1696330619"}]},"state":"08269884f9a9a4b8a7c16644221vvfda58bdd6a3"}';
    private string $withUpdateField = '{"account":{"subdomain":"nomoreerrors","id":"31310398","_links":{"self":"https:\/\/nomoreerrors.amocrm.ru"}},"leads":{"update":[{"id":"39958589","name":"\u041f\u043e\u043a\u0443\u043f\u043a\u0430 \u0433\u0440\u0438\u0431\u043e\u0432","status_id":"60650182","price":"200000","responsible_user_id":"10121570","last_modified":"1696330619","modified_user_id":"10121570","created_user_id":"10121570","date_create":"1696330619","pipeline_id":"7277538","tags":[{"id":"812623","name":"\u0438\u043c\u043f\u043e\u0440\u0442_03102023_1356"}],"account_id":"31310398","custom_fields":[{"id":"2505835","name":"\u0421\u0435\u0431\u0435\u0441\u0442\u043e\u0438\u043c\u043e\u0441\u0442\u044c","values":[{"value":"100000"}]}],"created_at":"1696330619","updated_at":"1696330619"}]},"state":"08269884f9a9a4b8a7c16644221vvfda58bdd6a3"}';
    private string $withAddField = '{"account":{"subdomain":"nomoreerrors","id":"31310398","_links":{"self":"https:\/\/nomoreerrors.amocrm.ru"}},"leads":{"add":[{"id":"39651909","name":"\u041f\u043e\u043a\u0443\u043f\u043a\u0430 \u0448\u043e\u043a\u043e\u043b\u0430\u0434\u0430","status_id":"60650182","price":"200000","responsible_user_id":"10121570","last_modified":"1696084299","modified_user_id":"10121570","created_user_id":"10121570","date_create":"1696084299","pipeline_id":"7277538","account_id":"31310398","custom_fields":[{"id":"2505835","name":"\u0421\u0435\u0431\u0435\u0441\u0442\u043e\u0438\u043c\u043e\u0441\u0442\u044c","values":[{"value":"140000"}]}],"created_at":"1696084299","updated_at":"1696084299"}]},"state":"08269884f9a9a4b8a7c16644221vvfda58bdd6a3"}';
    private string $withCustomFields = '{"account":{"subdomain":"nomoreerrors","id":"31310398","_links":{"self":"https:\/\/nomoreerrors.amocrm.ru"}},"leads":{"add":[{"id":"39651909","name":"\u041f\u043e\u043a\u0443\u043f\u043a\u0430 \u0448\u043e\u043a\u043e\u043b\u0430\u0434\u0430","status_id":"60650182","price":"200000","responsible_user_id":"10121570","last_modified":"1696084299","modified_user_id":"10121570","created_user_id":"10121570","date_create":"1696084299","pipeline_id":"7277538","account_id":"31310398","custom_fields":[{"id":"2505835","name":"\u0421\u0435\u0431\u0435\u0441\u0442\u043e\u0438\u043c\u043e\u0441\u0442\u044c","values":[{"value":"140000"}]}],"created_at":"1696084299","updated_at":"1696084299"}]},"state":"08269884f9a9a4b8a7c16644221vvfda58bdd6a3"}';
    private string $withoutCustomFields = '{"account":{"subdomain":"nomoreerrors","id":"31310398","_links":{"self":"https:\/\/nomoreerrors.amocrm.ru"}},"leads":{"update":[{"id":"39976531","name":"\u041f\u043e\u043a\u0443\u043f\u043a\u0430 \u043f\u0440\u044f\u043d\u0438\u043a\u043e\u0432","status_id":"60650182","price":"15000","responsible_user_id":"10121570","last_modified":"1696340287","modified_user_id":"10121570","created_user_id":"10121570","date_create":"1696340287","pipeline_id":"7277538","account_id":"31310398","created_at":"1696340287","updated_at":"1696340287"}]},"state":"08269884f9a9a4b8a7c16644221vvfda58bdd6a3"}';
    private string $withWrongState = '{"account":{"subdomain":"nomoreerrors","id":"31310398","_links":{"self":"https:\/\/nomoreerrors.amocrm.ru"}},"leads":{"update":[{"id":"39958589","name":"\u041f\u043e\u043a\u0443\u043f\u043a\u0430 \u0433\u0440\u0438\u0431\u043e\u0432","status_id":"60650182","price":"200000","responsible_user_id":"10121570","last_modified":"1696330619","modified_user_id":"10121570","created_user_id":"10121570","date_create":"1696330619","pipeline_id":"7277538","tags":[{"id":"812623","name":"\u0438\u043c\u043f\u043e\u0440\u0442_03102023_1356"}],"account_id":"31310398","custom_fields":[{"id":"2505835","name":"\u0421\u0435\u0431\u0435\u0441\u0442\u043e\u0438\u043c\u043e\u0441\u0442\u044c","values":[{"value":"100000"}]}],"created_at":"1696330619","updated_at":"1696330619"}]},"state":"08269884fvwefaegwgwef339a9a4b8a7c166da58bdd6a3"}';
    private string $withWrongId = '{"account":{"subdomain":"nomoreerrors","id":"313245234210398","_links":{"self":"https:\/\/nomoreerrors.amocrm.ru"}},"leads":{"update":[{"id":"39958589","name":"\u041f\u043e\u043a\u0443\u043f\u043a\u0430 \u0433\u0440\u0438\u0431\u043e\u0432","status_id":"60650182","price":"200000","responsible_user_id":"10121570","last_modified":"1696330619","modified_user_id":"10121570","created_user_id":"10121570","date_create":"1696330619","pipeline_id":"7277538","tags":[{"id":"812623","name":"\u0438\u043c\u043f\u043e\u0440\u0442_03102023_1356"}],"account_id":"31310398","custom_fields":[{"id":"2505835","name":"\u0421\u0435\u0431\u0435\u0441\u0442\u043e\u0438\u043c\u043e\u0441\u0442\u044c","values":[{"value":"100000"}]}],"created_at":"1696330619","updated_at":"1696330619"}]},"state":"08269884f9a9a4b8a7c16644221vvfda58bdd6a3"}';



    public function getWithValues()
    {
        $withValues = json_decode($this->withValues, true);
        return $withValues;
    }

    
    public function getWithoutValues(): array
    {
        $noValues = json_decode($this->noValues, true);
        return $noValues;
    }


    public function getWithAdd(): array
    {
        $withAddField = json_decode($this->withAddField, true);
        return $withAddField;
    }


    public function getWithUpdate(): array
    {
        $withUpdateField = json_decode($this->withUpdateField, true);
        return $withUpdateField;
    }


    public function getWithCustomFields(): array
    {
        $withCustomFields = json_decode($this->withCustomFields, true);
        return $withCustomFields;
    }


    public function getWithoutCustomFields(): array
    {
        $withoutCustomFields = json_decode($this->withoutCustomFields, true);
        return $withoutCustomFields;
    }


    public function getWithWrongState(): array
    {
        $withWrongState = json_decode($this->withWrongState, true);
        return $withWrongState;
    }


    public function getWithWrongId(): array
    {
        $withWrongId = json_decode($this->withWrongId, true);
        return $withWrongId;
    }
}