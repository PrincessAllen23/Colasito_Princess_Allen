<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * avatar_for
 * Returns an <img> tag (string) for a user's avatar. Uses Gravatar if email present,
 * otherwise falls back to an initials badge SVG data URI.
 *
 * @param string|null $email
 * @param string|null $name
 * @param int $size
 * @return string
 */
function avatar_for($email = null, $name = null, $size = 48)
{
    $size = (int)$size;
    $classes = "inline-block rounded-full overflow-hidden border-2 border-white/20 shadow-sm";

    if (!empty($email)) {
        $hash = md5(strtolower(trim($email)));
        $src = "https://www.gravatar.com/avatar/{$hash}?s={$size}&d=identicon&r=g";
        return "<img src=\"{$src}\" alt=\"avatar\" width=\"{$size}\" height=\"{$size}\" class=\"{$classes}\">";
    }

    // fallback to initials SVG
    $initials = 'U';
    if (!empty($name)) {
        $parts = preg_split('/\s+/', trim($name));
        if (count($parts) >= 2) {
            $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
        } else {
            $initials = strtoupper(substr($parts[0], 0, 1));
        }
    }

    $bg = '#4f46e5'; // indigo-600
    $fg = '#ffffff';
    $svg = rawurlencode("<svg xmlns='http://www.w3.org/2000/svg' width='{$size}' height='{$size}'><rect width='100%' height='100%' fill='{$bg}' rx='${size}' ry='${size}'/><text x='50%' y='50%' dy='.35em' text-anchor='middle' font-family='Helvetica,Arial,sans-serif' font-size='" . (int)($size/2.2) . "' fill='{$fg}'>" . htmlspecialchars(
        $initials,
        ENT_QUOTES,
        'UTF-8'
    ) . "</text></svg>");

    $src = "data:image/svg+xml;utf8,{$svg}";
    return "<img src=\"{$src}\" alt=\"avatar\" width=\"{$size}\" height=\"{$size}\" class=\"{$classes}\">";
}
