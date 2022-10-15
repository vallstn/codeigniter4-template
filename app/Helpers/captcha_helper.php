<?php

declare(strict_types=1);

use SimpleCaptcha\Builder;
use SimpleCaptcha\Helpers\Dir;
use SimpleCaptcha\Helpers\F;
use SimpleCaptcha\Helpers\Mime;	

	/**
     * Create CAPTCHA
     *
     * @param   array<string, string|int>|string $data     Data for the CAPTCHA
     * @param   string                           $imgPath  Path to create the image in (deprecated)
     * @param   string                           $imgUrl   URL to the CAPTCHA image folder (deprecated)
     * @param   string                           $fontPath Server path to font (deprecated)
     *
     * @return  array<string, mixed>
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    function createCaptcha(
        $data = '',
        string $imgPath = '',
        string $imgUrl = '',
        string $fontPath = ''
    ): array {		
        $now = microtime(true);
        $imgFilename = $now . '.png';

        if (isset($data['img_path'])) {
            $imgPath = $data['img_path'];
        }

        if (isset($data['img_url']) && is_string($data['img_url'])) {
            $imgUrl = $data['img_url'];
        }

        $word = $data['word'] ?? null;

        assert(is_string($word) || ($word === null));

        $imgTag = createImageTag($data, $imgUrl, $imgFilename);

        $builder = new Builder($word);		
        $builder->build();
        $builder->save($imgPath . $imgFilename);

        return [
            'word' => $word ?? $builder->phrase,
            'time' => $now,
            'image' => $imgTag,
            'filename' => $imgFilename,
        ];
    }

    /**
     * @param array<string, string|int>|string $data
     */
    function createImageTag($data, string $imgUrl, string $imgFilename): string
    {
        $imgId = $data['img_id'] ?? '';
        $imgSrc = rtrim($imgUrl, '/') . '/' . $imgFilename;
        $imgWidth = $data['img_width'] ?? 150;
        $imgHeight = $data['img_height'] ?? 30;
        $imgAlt = $data['img_alt'] ?? 'captcha';

        return '<img ' . ($imgId === '' ? '' : 'id="' . $imgId . '"')
            . ' src="' . $imgSrc . '" style="width: ' . $imgWidth
            . 'px; height: ' . $imgHeight . 'px; border: 0;" alt="'
            . $imgAlt . '" />';
    }
	
	# Render captcha image (using correct header)
	function sendImageHeader($data, string $imgUrl, string $imgFilename): string
    {
		header('Content-type: ' . Mime::fromExtension('jpg'));
		Builder::create()->build()->output();
	}
	
/**
 * CodeIgniter CAPTCHA Helper
 *
 * @link		https://codeigniter.com/userguide3/helpers/captcha_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('create_captcha'))
{
	/**
	 * Create CAPTCHA
	 *
	 * @param	array	$data		Data for the CAPTCHA
	 * @param	string	$img_path	Path to create the image in (deprecated)
	 * @param	string	$img_url	URL to the CAPTCHA image folder (deprecated)
	 * @param	string	$font_path	Server path to font (deprecated)
	 * @return	string
	 */
	function create_captcha($data = '', $img_path = '', $img_url = '', $font_path = '')
	{
		$defaults = array(
			'word'		=> '',
			'img_path'	=> '',
			'img_url'	=> '',
			'img_width'	=> '150',
			'img_height'	=> '30',
			'font_path'	=> '',
			'expiration'	=> 7200,
			'word_length'	=> 4,
			'font_size'	=> 16,
			'img_id'	=> '',
			'pool'		=> '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
			'colors'	=> array(
				'background'	=> array(255,255,255),
				'border'	=> array(153,102,102),
				'text'		=> array(204,153,153),
				'grid'		=> array(255,182,182)
			)
		);

		foreach ($defaults as $key => $val)
		{
			if ( ! is_array($data) && empty($$key))
			{
				$$key = $val;
			}
			else
			{
				$$key = isset($data[$key]) ? $data[$key] : $val;
			}
		}

		if ( ! extension_loaded('gd'))
		{
			log_message('error', 'create_captcha(): GD extension is not loaded.');
			return FALSE;
		}

		if ($img_path === '' OR $img_url === '')
		{
			log_message('error', 'create_captcha(): $img_path and $img_url are required.');
			return FALSE;
		}

		if ( ! is_dir($img_path) OR ! is_really_writable($img_path))
		{
			log_message('error', "create_captcha(): '{$img_path}' is not a dir, nor is it writable.");
			return FALSE;
		}

		// -----------------------------------
		// Remove old images
		// -----------------------------------

		$now = microtime(TRUE);

		$current_dir = @opendir($img_path);
		while ($filename = @readdir($current_dir))
		{
			if (in_array(substr($filename, -4), array('.jpg', '.png'))
				&& (str_replace(array('.jpg', '.png'), '', $filename) + $expiration) < $now)
			{
				@unlink($img_path.$filename);
			}
		}

		@closedir($current_dir);

		// -----------------------------------
		// Do we have a "word" yet?
		// -----------------------------------

		if (empty($word))
		{
			$word = '';
			$pool_length = strlen($pool);
			$rand_max = $pool_length - 1;

			// PHP7 or a suitable polyfill
			if (function_exists('random_int'))
			{
				try
				{
					for ($i = 0; $i < $word_length; $i++)
					{
						$word .= $pool[random_int(0, $rand_max)];
					}
				}
				catch (Exception $e)
				{
					// This means fallback to the next possible
					// alternative to random_int()
					$word = '';
				}
			}
		}

		if (empty($word))
		{
			// Nobody will have a larger character pool than
			// 256 characters, but let's handle it just in case ...
			//
			// No, I do not care that the fallback to mt_rand() can
			// handle it; if you trigger this, you're very obviously
			// trying to break it. -- Narf
			if ($pool_length > 256)
			{
				return FALSE;
			}

			// We'll try using the operating system's PRNG first,
			// which we can access through CI_Security::get_random_bytes()
			$security = get_instance()->security;

			// To avoid numerous get_random_bytes() calls, we'll
			// just try fetching as much bytes as we need at once.
			if (($bytes = $security->get_random_bytes($pool_length)) !== FALSE)
			{
				$byte_index = $word_index = 0;
				while ($word_index < $word_length)
				{
					// Do we have more random data to use?
					// It could be exhausted by previous iterations
					// ignoring bytes higher than $rand_max.
					if ($byte_index === $pool_length)
					{
						// No failures should be possible if the
						// first get_random_bytes() call didn't
						// return FALSE, but still ...
						for ($i = 0; $i < 5; $i++)
						{
							if (($bytes = $security->get_random_bytes($pool_length)) === FALSE)
							{
								continue;
							}

							$byte_index = 0;
							break;
						}

						if ($bytes === FALSE)
						{
							// Sadly, this means fallback to mt_rand()
							$word = '';
							break;
						}
					}

					list(, $rand_index) = unpack('C', $bytes[$byte_index++]);
					if ($rand_index > $rand_max)
					{
						continue;
					}

					$word .= $pool[$rand_index];
					$word_index++;
				}
			}
		}

		if (empty($word))
		{
			for ($i = 0; $i < $word_length; $i++)
			{
				$word .= $pool[mt_rand(0, $rand_max)];
			}
		}
		elseif ( ! is_string($word))
		{
			$word = (string) $word;
		}

		// -----------------------------------
		// Determine angle and position
		// -----------------------------------
		$length	= strlen($word);
		$angle	= ($length >= 6) ? mt_rand(-($length-6), ($length-6)) : 0;
		$x_axis	= mt_rand(6, (int)(360/$length)-16);
		$y_axis = ($angle >= 0) ? mt_rand((int)$img_height, (int)$img_width) : mt_rand(6, (int)$img_height);

		// Create image
		// PHP.net recommends imagecreatetruecolor(), but it isn't always available
		$im = function_exists('imagecreatetruecolor')
			? imagecreatetruecolor((int)$img_width, (int)$img_height)
			: imagecreate((int)$img_width, (int)$img_height);

		// -----------------------------------
		//  Assign colors
		// ----------------------------------

		is_array($colors) OR $colors = $defaults['colors'];

		foreach (array_keys($defaults['colors']) as $key)
		{
			// Check for a possible missing value
			is_array($colors[$key]) OR $colors[$key] = $defaults['colors'][$key];
			$colors[$key] = imagecolorallocate($im, $colors[$key][0], $colors[$key][1], $colors[$key][2]);
		}

		// Create the rectangle
		ImageFilledRectangle($im, 0, 0, (int)$img_width, (int)$img_height, $colors['background']);

		// -----------------------------------
		//  Create the spiral pattern
		// -----------------------------------
		$theta		= 1;
		$thetac		= 7;
		$radius		= 16;
		$circles	= 20;
		$points		= 32;

		for ($i = 0, $cp = ($circles * $points) - 1; $i < $cp; $i++)
		{
			$theta += $thetac;
			$rad = $radius * ($i / $points);
			$x = ($rad * cos($theta)) + $x_axis;
			$y = ($rad * sin($theta)) + $y_axis;
			$theta += $thetac;
			$rad1 = $radius * (($i + 1) / $points);
			$x1 = ($rad1 * cos($theta)) + $x_axis;
			$y1 = ($rad1 * sin($theta)) + $y_axis;
			imageline($im, (int)$x, (int)$y, (int)$x1, (int)$y1, $colors['grid']);
			$theta -= $thetac;
		}

		// -----------------------------------
		//  Write the text
		// -----------------------------------

		$use_font = ($font_path !== '' && file_exists($font_path) && function_exists('imagettftext'));
		if ($use_font === FALSE)
		{
			($font_size > 5) && $font_size = 5;
			$x = mt_rand(0, (int)($img_width / ($length / 3)));
			$y = 0;
		}
		else
		{
			($font_size > 30) && $font_size = 30;
			$x = mt_rand(0, (int)($img_width / ($length / 1.5)));
			$y = $font_size + 2;
		}

		for ($i = 0; $i < $length; $i++)
		{
			if ($use_font === FALSE)
			{
				$y = mt_rand(0 , $img_height / 2);
				imagestring($im, $font_size, $x, $y, $word[$i], $colors['text']);
				$x += ($font_size * 2);
			}
			else
			{
				$y = mt_rand($img_height / 2, $img_height - 3);
				imagettftext($im, $font_size, $angle, $x, $y, $colors['text'], $font_path, $word[$i]);
				$x += $font_size;
			}
		}

		// Create the border
		imagerectangle($im, 0, 0, $img_width - 1, $img_height - 1, $colors['border']);

		// -----------------------------------
		//  Generate the image
		// -----------------------------------
		$img_url = rtrim($img_url, '/').'/';

		if (function_exists('imagejpeg'))
		{
			$img_filename = $now.'.jpg';
			imagejpeg($im, $img_path.$img_filename);
		}
		elseif (function_exists('imagepng'))
		{
			$img_filename = $now.'.png';
			imagepng($im, $img_path.$img_filename);
		}
		else
		{
			return FALSE;
		}

		$img = '<img '.($img_id === '' ? '' : 'id="'.$img_id.'"').' src="'.$img_url.$img_filename.'" style="width: '.$img_width.'px; height: '.$img_height .'px; border: 0;" alt=" " />';
		ImageDestroy($im);

		return array('word' => $word, 'time' => $now, 'image' => $img, 'filename' => $img_filename);
	}
}
