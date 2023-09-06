<?php

namespace theme\helpers;

/**
 *
 */
class Curl
{
    private $_session;
    private $_response;
    private string $_error;

    /**
     * @param array $props
     */
    public function __construct(array $props)
    {
        $this->_session = curl_init();

        curl_setopt_array($this->_session, $props);
    }

    /**
     * @return void
     */
    public function exec()
    {
        $this->_response = curl_exec($this->_session);
        $this->_error = curl_error($this->_session);
    }

    /**
     * @return void
     */
    public function close() {
        curl_close($this->_session);
    }

    /**
     * @return bool|string
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->_error;
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->close();
    }
}