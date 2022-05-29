<?php

namespace Uncgits\CanvasApi;

/**
 * Represents a set of results from the API, obtained via one or more API calls
 */
class CanvasApiResult
{
    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /**
     * The API calls that were made to get this resultset
     *
     * @var array
     */
    protected $calls = [];

    /**
     * The overall status of the API resultset
     *
     * @var string
     */
    protected $status = '';

    /**
     * Longer message representing the status of the API resultset
     *
     * @var string
     */
    protected $message = '';

    /**
     * A collection of Canvas Resources obtained in this resultset
     *
     * @var array
     */
    protected $content = [];

    /**
     * The Canvas API configuration used to generate this resultset
     *
     * @var CanvasApiConfig
     */
    protected $config;

    protected $abortCodes = [];

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    /**
     * Get the API calls that were made to get this resultset
     *
     * @return  array
     */
    public function getCalls()
    {
        return $this->calls;
    }

    /**
     * Get the last API call made for this resultset
     *
     * @return  array
     */
    public function getLastCall()
    {
        return $this->calls[] = array_pop($this->calls);
    }

    /**
     * Get the first API call made for this resultset
     *
     * @return  array
     */
    public function getFirstCall()
    {
        return $this->calls[0];
    }

    /**
     * Get the overall status of the API resultset
     *
     * @return  string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get longer message representing the status of the API resultset
     *
     * @return  string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get content of the resultset
     *
     * @return  array
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Gets the last code and message.
     *
     * @return array
     */
    public function getLastResult()
    {
        return [
            'code'   => $this->getLastCall()['response']['code'],
            'reason' => $this->getLastCall()['response']['reason']
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Setters
    |--------------------------------------------------------------------------
    */

    /**
     * Set the API calls that were made to get this resultset
     *
     * @param  array  $calls  The API calls that were made to get this resultset
     *
     * @return  self
     */
    public function setCalls(array $calls)
    {
        $this->calls = $calls;
        return $this;
    }

    /**
     * Set the overall status of the API resultset
     *
     * @param  string  $status  The overall status of the API resultset
     *
     * @return  self
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Set longer message representing the status of the API resultset
     *
     * @param  string  $message  Longer message representing the status of the API resultset
     *
     * @return  self
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }
//    Bu metot 400 üzeri alanın statü kodlarında istenildiğinde abort fırlatmak için kullanılır.
    public function throwAbort(){
        if(count($this->abortCodes) >= 1 and current($this->abortCodes) == 404)
            abort(current($this->abortCodes));
        else
            return $this;
    }
    public function errorRedirect($response = false){
        if($this->errorMessage()){
            if(!$response)
                return redirect()->back()->with(["apierrors" => $this->errorMessage()]);
            else
                return response()->json(["apierrors" => $this->errorMessage()]);

        }
        else
            return $this;
    }
    public function getErrors(){
        return !empty($this->content->errors) ? $this->content->errors : false;
    }
    public function errorMessage(){
        if($this->getErrors()){
//      Std objesinin array dönüşümünü yapıyoruz.
        $ilkError =  ((array)$this->content->errors);
//       Gelen eleman dizi değil ise direkt message'yi döndürüyoruz , dizi ise ilk elemanın içine girip onun message'sini döndürüyoruz.
            // Burada error sayısı 1'den küçük ise ve ilk elemanın ilk elemanın message adında bir attributesi var ise, girilir.
        if(count($ilkError) <= 1 and !empty(current(current($ilkError))->message)){
            $ilkError = current(current($ilkError));
            return $this->errorTranslate("---{$ilkError->attribute}--- ".$ilkError->message);
        }
        // Burada eleman sayısı birden fazla ise bir sonraki elemanın ilk elemanının ilk elemanını alınır.
        else if(count($ilkError) > 1){
            $ilkError = current(current((next($ilkError))));
            return $this->errorTranslate("---{$ilkError->attribute}---".$ilkError->message);
        }
        // Burada direkt sadece mesaj verildiyse ve bir elemanı var ise hata mesajı ekrana basılır.
        else{
            $ilkError = current($ilkError);
            return $this->errorTranslate($ilkError->message);
        }
    }
    else{
        return false;
    }
    }
//   Burada tüm hata mesajlarını translate ediyoruz.
    public function errorTranslate(String $string){
     return __($string);
    }
    public function __construct(array $calls, CanvasApiConfig $config)
    {
        // set config
        $this->config = $config;
        // set the calls
        $this->setCalls($calls);
        // parse calls to get results and content
        $this->parseCalls($calls);
    }

    public function parseCalls()
    {
        // parse content
        $failedCalls = [];

        foreach ($this->calls as $call) {
            if ($call['response']['code'] >= 400) {
                $failedCalls[] = $call;
                $this->abortCodes[] = $call['response']['code'];
            }

            if (isset($call['response']['body']) && !empty($call['response']['body'])) {
                $body = $call['response']['body'];
                if (is_object($body)) {
                    if (isset($body->id) || isset($body->feature) || isset($body->errors) || isset($body->message) || isset($body->delete) || isset($body->conclude) || isset($body->quota)) {
                        // handle single results or errors.
                        // also special handling for "feature" (feature flags API), and delete/conclude (course deletion API)... TODO: how to handle this better?
                        $this->content = $body;
                    } else {
                        // some things like enrollment lists are embedded another level deep...
                        $bodyArray = (array) $body;
                        $this->content = array_merge($this->content, array_pop($bodyArray));
                    }
                } else {
                    $this->content = array_merge($this->content, $body);
                }
            }
        }

        // trim results if we only asked for X (silly, yes... but...)
        if (is_array($this->content) && (count($this->content) > $this->config->getMaxResults())) {
            $this->content = array_slice($this->content, 0, $this->config->getMaxResults());
        }

        $this->status = empty($failedCalls) ? 'success' : 'error';
        $this->message = empty($failedCalls) ?
            count($this->calls) . ' call(s) successful.' :
            count($failedCalls) . ' call(s) had errors.';

        return $this;
    }
}
