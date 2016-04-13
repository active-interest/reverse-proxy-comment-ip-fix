<?php
/*
Plugin Name: Reverse-Proxy Comment IP Fix
Plugin URI: http://www.codetrax.org/projects/reverse-proxy-comment-ip-fix
Description: Sets the comment IP to the client IP provided by the X-Forwarded-For or X-Real-IP headers before the comment is saved to the database.
Version: 0.2.0
Author: George Notaras
Author URI: http://www.g-loaded.eu/
License: Apache License V2
*/

/*
Copyright 2012-2016 George Notaras <gnot@g-loaded.eu>, CodeTRAX.org

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

function rpcif__set_client_ip( $default ) {

    // Store the IP address of the REMOTE_ADDR server variable.
    $client_ip = $_SERVER['REMOTE_ADDR'];

    // Determine the IP address by checking the following headers.

    $ip_addr = null;

    // Check X-Real-IP header (non standard)
    if ( ! empty($_SERVER['X_REAL_IP']) ) {
        $ip_addr = trim($_SERVER['X_REAL_IP']);
    } elseif ( ! empty($_SERVER['HTTP_X_REAL_IP']) ) {
        $ip_addr = trim($_SERVER['HTTP_X_REAL_IP']);
    }
    // Check X-Forwarded-For
    elseif ( ! empty($_SERVER['X_FORWARDED_FOR']) ) {
        $ips = explode(',', $_SERVER['X_FORWARDED_FOR']);
        $ip_addr = trim($ips[0]);
    } elseif ( ! empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip_addr = trim($ips[0]);
    }

    // Check if we have an IP address.
    if ( empty($ip_addr) ) {
        return $client_ip;
    }

    // Validate

    // IPv4 pattern
    $ipv4_pattern = '#^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$#';
    // IPv6 pattern
    // From: http://stackoverflow.com/questions/53497/regular-expression-that-matches-valid-ipv6-addresses
    $ipv6_pattern = '#^(([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,7}:|([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}|([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}|([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}|([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}|[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})|:((:[0-9a-fA-F]{1,4}){1,7}|:)|fe80:(:[0-9a-fA-F]{0,4}){0,4}%[0-9a-zA-Z]{1,}|::(ffff(:0{1,4}){0,1}:){0,1}((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])|([0-9a-fA-F]{1,4}:){1,4}:((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9]))$#';

    if ( ! preg_match($ipv4_pattern, $ip_addr, $matches) ) {
        if ( ! preg_match($ipv6_pattern, $ip_addr, $matches) ) {
            return $client_ip;
        }
    }

    return $ip_addr;
}
add_filter ('pre_comment_user_ip', 'rpcif__set_client_ip');

