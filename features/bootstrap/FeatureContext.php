<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->bearerToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjcxZTVmOTljNjIyYjY4YmQwYWI5ZmVjNzJkNGQyNDQ2NDM3OWFmMzRiY2VlOWY5YWM4Yzc4MTY3MjBjNDYxODFhMzI0MjcwMTcwMjIzYzQ3In0.eyJhdWQiOiI1IiwianRpIjoiNzFlNWY5OWM2MjJiNjhiZDBhYjlmZWM3MmQ0ZDI0NDY0Mzc5YWYzNGJjZWU5ZjlhYzhjNzgxNjcyMGM0NjE4MWEzMjQyNzAxNzAyMjNjNDciLCJpYXQiOjE1NDc0OTk0NzksIm5iZiI6MTU0NzQ5OTQ3OSwiZXhwIjoxNTc5MDM1NDc4LCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.YNTE73-eSFf3CaAqpBvgleAdFeiHNK59a1YDaswxMMVikzAM3LBPtuojek9zJoY_upqyI5Bah8EimBN1v4JJEySCJ98xodcuj5tP8sUiFixZxzxn2owytggtYYeodAwE5ZSv-VGjuk5cHlaGYG3PVQPqubcwU_gZcIeUDN6lWYSkBidCLf6exADt6qrrGaBFdc37fei7ehp6gRqYDGYLAXwgkzQnzm0vSRS2fKdDJzY-wnoLHAGSqfIwf_wbk36Ixt0QS2N-sM-oCWe2xQvablLG23CdveQhJ3XPYdTYXBXhcb6aJXU2ioKV83ny4UHchuRvgokbkBCHnIVLY90zFsUvSRwdJhLSRUxYfykMgDc3XWyT00RgB9LaAl7HUENeBmnJ90nkIHM0PahPoKMdQms9TZUsa-74ZIf0_I-ovtubdfE-2xvJJmJFieRyMQ1YpB-RkEcQqhFKm9edCokt8Oi8CVQx-_ooHH4W2sZR5-eOzJ_IoHBD7OFSIca0IXgFgs9kAAK2Q2HN61oz8aXURDRM1MeLK6eOyU0PS5WIYx4_0R0LZRur3JFManYMfEz6y6B0CKSBHsBjyK5ESpdDASXPLeszJUwqxEU85zci3VSxcvYg1wjcnBZYAfdX7ynfEhDO2c9d-5HwuKGTu52JqU65ggoMObvLBKQdtsNYETg";
    }

    /**
     * @Given I have the payload:
     */
    public function iHaveThePayload(PyStringNode $string)
    {
        $this->payload = $string;
    }

    /**
     * @When /^I request "(GET|PUT|POST|DELETE|PATCH) ([^"]*)"$/
     */
    public function iRequest($httpMethod, $argument1)
    {
        $client = new GuzzleHttp\Client();
        $this->response = $client->request(
            $httpMethod,
            'http://127.0.0.1:8000' . $argument1,
            [
                'body' => $this->payload,
                'headers' => [
                    "Authorization" => "Bearer {$this->bearerToken}",
                    "Content-Type" => "application/json",
                ],
            ]
        );
        $this->responseBody = $this->response->getBody(true);
    }

    /**
     * @Then /^I get a response$/
     */
    public function iGetAResponse()
    {
        if (empty($this->responseBody)) {
            throw new Exception('Did not get a response from the API');
        }
    }

    /**
     * @Given /^the response is JSON$/
     */
    public function theResponseIsJson()
    {
        $data = json_decode($this->responseBody);

        if (empty($data)) {
            throw new Exception("Response was not JSON\n" . $this->responseBody);
        }
    }

    /**
     * @Then the response contains :arg1 records
     */
    public function theResponseContainsRecords($arg1)
    {
        // throw new PendingException();
        $data = json_decode($this->responseBody);
        $count = count($data);
        return ($count == $arg1);
    }

    /**
     * @Then the response contains a question
     */
    public function theResponseContainsAQuestion()
    {
        $data = json_decode($this->responseBody);
        $question = $data[0];

        if ( ! property_exists($question, 'question')) 
        {
            throw new Exception('This is not a question');
        }
    }

    /**
     * @Then the question contains a title of :arg1
     */
    public function theQuestionContainsATitleOf($arg1)
    {
        $data = json_decode($this->responseBody);
        // dd($data->title);
        if ($data->title != $arg1) 
        {
            throw new Exception ("Invalid question - Title doesnot match the word {$arg1}");
        }
        // throw new PendingException();
    }



}