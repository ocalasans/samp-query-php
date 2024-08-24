<?php

class samp_query
{
    private $socket = null;
    private $serverInfo = [];
    private $retryLimit = 3;
    private $timeouts = []; 
    //
    public function __construct($serverAddress, $port = 7777)
    {
        $this->serverInfo['address'] = $serverAddress;
        $this->serverInfo['port'] = $port;
        //
        $this->timeouts['connect'] = 1;
        $this->timeouts['response'] = 120;
        //
        for($attempt = 0; $attempt < $this->retryLimit; $attempt++)
        {
            $this->socket = @fsockopen('udp://' . $this->serverInfo['address'], $this->serverInfo['port'], $errCode, $errMsg, $this->timeouts['response']);
            if($this->socket)
                break;
        }
        //
        if(!$this->socket)
        {
            $this->serverInfo['online'] = false;
            //
            return;
        }
        //
        $startTime = microtime(true);
        //
        stream_set_timeout($this->socket, $this->timeouts['connect']);
        //
        $packet = 'SAMP';
        $packet .= chr(intval(strtok($this->serverInfo['address'], '.')));
        $packet .= chr(intval(strtok('.')));
        $packet .= chr(intval(strtok('.')));
        $packet .= chr(intval(strtok('.')));
        $packet .= chr($this->serverInfo['port'] & 0xFF);
        $packet .= chr($this->serverInfo['port'] >> 8 & 0xFF);
        $packet .= 'p4150';
        //
        fwrite($this->socket, $packet);
        //
        if(fread($this->socket, 10) && fread($this->socket, 5) == 'p4150')
        {
            $this->serverInfo['online'] = true;
            //
            $this->serverInfo['ping'] = round((microtime(true) - $startTime) * 1000);
            //
            return;
        }
        //
        $this->serverInfo['online'] = false;
    }
    //
    public function __destruct()
    {
        if($this->socket)
        {
            fclose($this->socket);
        }
    }
    //
    private function attempt($operation)
    {
        for($i = 0; $i < $this->retryLimit; $i++)
        {
            $result = $operation();
            if($result !== null)
            {
                return $result;
            }
        }
        //
        return null;
    }
    //
    public function Ist_Online()
    {
        return $this->serverInfo['online'] ?? false;
    }
    //
    public function Abfragen_Ping()
    {
        return $this->serverInfo['ping'] ?? null;
    }
    //
    public function Abfragen_Informationen()
    {
        return $this->attempt(function()
        {
            fwrite($this->socket, $this->buildPacket('i'));
            //
            if(!fread($this->socket, 11))
            {
                return null;
            }
            //
            $info['passworded'] = ord(fread($this->socket, 1));
            $info['players'] = $this->toInt(fread($this->socket, 2));
            $info['maxplayers'] = $this->toInt(fread($this->socket, 2));
            //
            $hostnameLength = ord(fread($this->socket, 4));
            if(!$hostnameLength)
                return null;
            //
            $info['hostname'] = fread($this->socket, $hostnameLength);
            //
            $gamemodeLength = ord(fread($this->socket, 4));
            if(!$gamemodeLength)
                return null;
            //
            $info['gamemode'] = fread($this->socket, $gamemodeLength);
            //
            $languageLength = ord(fread($this->socket, 4));
            if(!$languageLength)
                return null;
            //
            $info['language'] = fread($this->socket, $languageLength);
            //
            return $info;
        });
    }
    //
    public function Abfragen_Spieler_0()
    {
        return $this->attempt(function()
        {
            fwrite($this->socket, $this->buildPacket('c'));
            //
            if(!fread($this->socket, 11))
            {
                return null;
            }
            //
            $playerCount = ord(fread($this->socket, 2));
            $players = [];
            //
            if($playerCount > 0)
            {
                for($i = 0; $i < $playerCount; $i++)
                {
                    $nameLength = ord(fread($this->socket, 1));
                    $players[] = [
                        'nickname' => fread($this->socket, $nameLength),
                        'score' => $this->toInt(fread($this->socket, 4)),
                    ];
                }
            }
            //
            return $players;
        });
    }
    //
    public function Abfragen_Spieler_1()
    {
        return $this->attempt(function()
        {
            fwrite($this->socket, $this->buildPacket('d'));
            //
            if(!fread($this->socket, 11))
            {
                return null;
            }
            //
            $playerCount = ord(fread($this->socket, 2));
            $detailedPlayers = [];
            //
            if($playerCount > 0)
            {
                for($i = 0; $i < $playerCount; $i++)
                {
                    $player = [];
                    $player['playerid'] = ord(fread($this->socket, 1));
                    //
                    $nameLength = ord(fread($this->socket, 1));
                    $player['nickname'] = fread($this->socket, $nameLength);
                    //
                    $player['score'] = $this->toInt(fread($this->socket, 4));
                    $player['ping'] = $this->toInt(fread($this->socket, 4));
                    //
                    $detailedPlayers[] = $player;
                }
            }
            //
            return $detailedPlayers;
        });
    }
    //
    public function Abfragen_Regeln()
    {
        return $this->attempt(function()
        {
            fwrite($this->socket, $this->buildPacket('r'));
            //
            if(!fread($this->socket, 11))
            {
                return null;
            }
            //
            $ruleCount = ord(fread($this->socket, 2));
            $rules = [];
            //
            if($ruleCount > 0)
            {
                for($i = 0; $i < $ruleCount; $i++)
                {
                    $ruleNameLength = ord(fread($this->socket, 1));
                    $ruleName = fread($this->socket, $ruleNameLength);
                    //
                    $ruleValueLength = ord(fread($this->socket, 1));
                    $rules[$ruleName] = fread($this->socket, $ruleValueLength);
                }
            }
            //
            return $rules;
        });
    }
    //
    private function toInt($data)
    {
        if($data === "")
        {
            return null;
        }
        //
        $integer = 0;
        $integer += ord($data[0]);
        //
        if(isset($data[1]))
        {
            $integer += ord($data[1]) << 8;
        }
        //
        if(isset($data[2]))
        {
            $integer += ord($data[2]) << 16;
        }
        //
        if(isset($data[3]))
        {
            $integer += ord($data[3]) << 24;
        }
        //
        if($integer >= 4294967294)
        {
            $integer -= 4294967296;
        }
        //
        return $integer;
    }
    //
    private function buildPacket($command)
    {
        $packet = 'SAMP';
        $packet .= chr(intval(strtok($this->serverInfo['address'], '.')));
        $packet .= chr(intval(strtok('.')));
        $packet .= chr(intval(strtok('.')));
        $packet .= chr(intval(strtok('.')));
        $packet .= chr($this->serverInfo['port'] & 0xFF);
        $packet .= chr($this->serverInfo['port'] >> 8 & 0xFF);
        $packet .= $command;
        //
        return $packet;
    }
}
