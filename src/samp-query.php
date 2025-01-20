<?php

class Samp_Query
{
    private $socket = null;
    private $server_info = [];
    private $retry_limit = 3;
    private $timeouts = []; 
    
    public function __construct($server_address, $port = 7777)
    {
        $this->server_info['address'] = $server_address;
        $this->server_info['port'] = $port;
        
        $this->timeouts['connect'] = 1;
        $this->timeouts['response'] = 120;
        
        for($attempt = 0; $attempt < $this->retry_limit; $attempt++)
        {
            $this->socket = @fsockopen('udp://' . $this->server_info['address'], $this->server_info['port'], $err_code, $err_msg, $this->timeouts['response']);

            if($this->socket)
                break;
        }
        
        if(!$this->socket)
        {
            $this->server_info['online'] = false;
            
            return;
        }
        
        $start_time = microtime(true);
        
        stream_set_timeout($this->socket, $this->timeouts['connect']);
        
        $packet = 'SAMP';
        $packet .= chr(intval(strtok($this->server_info['address'], '.')));
        $packet .= chr(intval(strtok('.')));
        $packet .= chr(intval(strtok('.')));
        $packet .= chr(intval(strtok('.')));
        $packet .= chr($this->server_info['port'] & 0xFF);
        $packet .= chr($this->server_info['port'] >> 8 & 0xFF);
        $packet .= 'p4150';
        
        fwrite($this->socket, $packet);
        
        if(fread($this->socket, 10) && fread($this->socket, 5) == 'p4150')
        {
            $this->server_info['online'] = true;
            
            $this->server_info['ping'] = round((microtime(true) - $start_time) * 1000);
            
            return;
        }
        
        $this->server_info['online'] = false;
    }
    
    public function __destruct()
    {
        if($this->socket)
            fclose($this->socket);
    }
    
    private function attempt($operation)
    {
        for($i = 0; $i < $this->retry_limit; $i++)
        {
            $result = $operation();

            if($result !== null)
                return $result;
        }

        return null;
    }
    public function Is_Online()
    {
        return $this->server_info['online'] ?? false;
    }

    public function Get_Ping()
    {
        return $this->server_info['ping'] ?? null;
    }

    public function Get_Information()
    {
        return $this->attempt(function()
        {
            fwrite($this->socket, $this->Build_Packet('i'));

            if(!fread($this->socket, 11))
                return null;

            $info['passworded'] = ord(fread($this->socket, 1));
            $info['players'] = $this->To_Int(fread($this->socket, 2));
            $info['maxplayers'] = $this->To_Int(fread($this->socket, 2));
            
            $hostname_length = ord(fread($this->socket, 4));

            if(!$hostname_length)
                return null;
            
            $info['hostname'] = fread($this->socket, $hostname_length);
            
            $gamemode_length = ord(fread($this->socket, 4));

            if(!$gamemode_length)
                return null;
            
            $info['gamemode'] = fread($this->socket, $gamemode_length);
            
            $language_length = ord(fread($this->socket, 4));

            if(!$language_length)
                return null;
            
            $info['language'] = fread($this->socket, $language_length);
            
            return $info;
        });
    }
    
    public function Get_Players_0()
    {
        return $this->attempt(function()
        {
            fwrite($this->socket, $this->Build_Packet('c'));
            fread($this->socket, 11);
            
            $player_count = ord(fread($this->socket, 2));
            $players = [];
            
            if($player_count > 0)
            {
                for($i = 0; $i < $player_count; $i++)
                {
                    $name_length = ord(fread($this->socket, 1));
                    $players[] = [
                        'nickname' => fread($this->socket, $name_length),
                        'score' => $this->To_Int(fread($this->socket, 4)),
                    ];
                }
            }
            
            return $players;
        });
    }

    public function Get_Players_1()
    {
        return $this->attempt(function()
        {
            fwrite($this->socket, $this->Build_Packet('d'));
            fread($this->socket, 11);
            
            $player_count = ord(fread($this->socket, 2));
            $detailed_players = [];
            
            if($player_count > 0)
            {
                for($i = 0; $i < $player_count; $i++)
                {
                    $player = [];
                    $player['playerid'] = ord(fread($this->socket, 1));
                    
                    $name_length = ord(fread($this->socket, 1));
                    $player['nickname'] = fread($this->socket, $name_length);
                    
                    $player['score'] = $this->To_Int(fread($this->socket, 4));
                    $player['ping'] = $this->To_Int(fread($this->socket, 4));
                    
                    $detailed_players[] = $player;
                }
            }
            
            return $detailed_players;
        });
    }
    
    public function Get_Rules()
    {
        return $this->attempt(function()
        {
            fwrite($this->socket, $this->Build_Packet('r'));
            
            if(!fread($this->socket, 11))
                return null;
            
            $rule_count = ord(fread($this->socket, 2));
            $rules = [];
            
            if($rule_count > 0)
            {
                for($i = 0; $i < $rule_count; $i++)
                {
                    $rule_name_length = ord(fread($this->socket, 1));
                    $rule_nname = fread($this->socket, $rule_name_length);
                    
                    $rule_value_length = ord(fread($this->socket, 1));
                    $rules[$rule_nname] = fread($this->socket, $rule_value_length);
                }
            }
            
            return $rules;
        });
    }
    
    private function To_Int($data)
    {
        if($data === "")
            return null;
        
        $integer = 0;
        $integer += ord($data[0]);
        
        if(isset($data[1]))
            $integer += ord($data[1]) << 8;

        if(isset($data[2]))
            $integer += ord($data[2]) << 16;

        if(isset($data[3]))
            $integer += ord($data[3]) << 24;

        if($integer >= 4294967294)
            $integer -= 4294967296;

        return $integer;
    }
    
    private function Build_Packet($command)
    {
        $packet = 'SAMP';
        $packet .= chr(intval(strtok($this->server_info['address'], '.')));
        $packet .= chr(intval(strtok('.')));
        $packet .= chr(intval(strtok('.')));
        $packet .= chr(intval(strtok('.')));
        $packet .= chr($this->server_info['port'] & 0xFF);
        $packet .= chr($this->server_info['port'] >> 8 & 0xFF);
        $packet .= $command;
        
        return $packet;
    }
}