<?php

/**
 * This service class encapsulates football-data.org's RESTful API.
 *
 * @author Daniel Freitag <daniel@football-data.org>
 * @date 04.11.2015 | switched to v2 09.08.2018
 * 
 */
/*
 * @update: LR 18.09.2018
 */
class FootballData {
    
    public $config;
    public $baseUri;
    public $reqPrefs = array();
        
    public function __construct() {
        $this->config = parse_ini_file('config.ini', true);

	// some lame hint for the impatient
	if($this->config['authToken'] == 'YOUR_AUTH_TOKEN' || !isset($this->config['authToken'])) {
		exit('Get your API-Key first and edit config.ini');
	}
        
        $this->baseUri = $this->config['baseUri']; 
        
        $this->reqPrefs['http']['method'] = 'GET';
        $this->reqPrefs['http']['header'] = 'X-Auth-Token: ' . $this->config['authToken'];
    }
    
    /**
     * Function returns a particular competition identified by an id.
     * 
     * @param Integer $id
     * @return array
     */        
    public function findCompetitionById($id) {
        $resource = 'competitions/' . $id;
        $response = file_get_contents($this->baseUri . $resource, false, 
                                      stream_context_create($this->reqPrefs));
        
        return json_decode($response);
    }
    
    /**
     * Function returns all available matches for a given date range.
     * 
     * @param DateString 'Y-m-d' $start
     * @param DateString 'Y-m-d' $end
     * 
     * @return array of matches
     */    
    public function findMatchesForDateRange($start, $end) {
        $resource = 'matches/?dateFrom=' . $start . '&dateTo=' . $end.'&status=SCHEDULED' ;

        $response = file_get_contents($this->baseUri . $resource, false, 
                                      stream_context_create($this->reqPrefs));
        
        return json_decode($response);
    }
    
    public function findMatchesFinished($start, $end) {
        $resource = 'matches/?dateFrom=' . $start . '&dateTo=' . $end.'&status=FINISHED' ;
        $response = file_get_contents($this->baseUri . $resource, false, 
                                      stream_context_create($this->reqPrefs));
        
        return json_decode($response);
    }
    
    public function findMatchesInPlay($start, $end) {
        $resource = 'matches/?dateFrom=' . $start . '&dateTo=' . $end.'&status=IN_PLAY' ;
        $response = file_get_contents($this->baseUri . $resource, false, 
                                      stream_context_create($this->reqPrefs));
        
        return json_decode($response);
    }
    
    
    
}
