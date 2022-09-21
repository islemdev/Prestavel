<?php
namespace Islemdev\Prestavel;
use Illuminate\Support\Facades\Http;
use Islemdev\Prestavel\Exceptions\InvalidOperatorException;
use Islemdev\Prestavel\Exceptions\InvalidPrestashopEndPonint;
use Islemdev\Prestavel\Exceptions\InvalidPrestashopToken;

use Illuminate\Support\Str;

class PrestavelConnector
{
    protected $query_params = [];
    
    public function __construct($base_url, $api_token)
    {
        //check check base url is set
        if($base_url === null)
            throw new InvalidPrestashopEndPonint("Please set your prestashop endpoint in the config file");
        if($base_url === null)
            throw new InvalidPrestashopToken("Please set your prestashop api token in the config file");

        $this->api_base_url = $base_url.'/api';
        $this->api_token = $api_token;
        try {
            $this->http_client = Http::withHeaders([
                'Output-Format' => 'JSON',
            ])
            ->withBasicAuth($this->api_token, '');
        } catch(\Exception $e) {

        }

    }


    protected function addQueryParameters($key, $value)
    {
        $this->query_params[$key] = $value;
    }

    public function from($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    public function get()
    {
        $rows = $this->http_client->get($this->api_base_url.'/'.$this->resource, $this->query_params)->json();
        return count($rows) > 0 ? 
         collect($rows[$this->resource]) : 
         $rows[$this->resource];
    }

    public function select(...$args)
    {
        if(in_array("*", $args))
            $this->addQueryParameters('display', 'full');
        else
            $this->addQueryParameters('display', '['.implode(',', $args).']');
        return $this;
    }

    public function where(...$args)
    {
        $count = count($args);
        if($count == 2) { //equals
            $field = $args[0];
            $value = $args[1];
            $this->addValueToFilter("filter[".$field."]", $value);
        } elseif ($count == 3) {
            $field = $args[0];
            $value = $args[2];
            
            $op = $this->guessOperator($args[1]);
            $this->addValueToFilter("filter[".$field."]", $value, $op);
        } elseif ($this->isMultidemonsielArray($args)) {
            foreach ($args as $arg) {
                $field = $arg[0];
                $value = $arg[2];
                
                $op = $this->guessOperator($arg[1]);
                $this->addValueToFilter("filter[".$field."]", $value, $op);
            }
        }


        return $this;
    }

    protected function guessOperator($operator)
    {
        switch($operator) {
            case '='://equals
                $op = '';
                break;
            case '>'://grater than
                $op ='>';
                break;
            case '<': //lower than
                $op = '<';
                break;
            case '!='://not equals
                $op='!';
                break;
            default:
                throw new InvalidOperatorException("Invalid operator ".$operator." possible operators are: =, >, < and !=");
        }

        return $op;
    }

    protected function addValueToFilter($filter, $value, $op=''): void
    {
        if(isset($this->query_params[$filter])) {
            $values = Str::between($this->query_params[$filter], '[',']');
            $separator = '|';
            $values_array = explode($separator, $values);
            $values_array[] = $value;
            $new_values = implode($separator, $values_array);
            $new_values = str_replace($values, $new_values, $this->query_params[$filter]);
            $this->addQueryParameters($filter, $new_values);

        } else {
            $this->addQueryParameters($filter, $op."[".$value."]");
        }
    }

    protected function isMultidemonsielArray($array)
    {
        return count($array) != count($array, COUNT_RECURSIVE);
    }
}