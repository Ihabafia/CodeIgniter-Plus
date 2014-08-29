<?php
/**
 * @name        CodeIgniter Advanced Images
 * @author         Jens Segers
 * @link           http://www.jenssegers.be
 * @license        MIT License Copyright (c) 2012 Jens Segers
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Image
 *
 * Generates a modified image source to work with the advanced images controller
 *
 * @access    public
 * @param    mixed
 * @return    string
 */
if (!function_exists('image')) {
	function image($image_path, $preset) {
		$ci = & get_instance();

		// load the allowed image presets
		$ci->load->config("images");
		$sizes = $ci->config->item("image_sizes");

		$pathinfo = pathinfo($image_path);
		$new_path = $image_path;

		// check if requested preset exists
		if (isset($sizes[$preset])) {
			$new_path = $pathinfo["dirname"] . "/" . $pathinfo["filename"] . "-" . implode("x", $sizes[$preset]) . "." . $pathinfo["extension"];
		}

		return $new_path;
	}
}

if (!function_exists('clean')) {
	function clean($image_path) {
		$ci = & get_instance();

		// load the allowed image presets
		$ci->load->config("images");
		$sizes = $ci->config->item("image_sizes");

		$pathinfo   = pathinfo($image_path);
		$image_path = realpath('car_uploads');

		foreach ($sizes as $size) {
			$file = $image_path . "/" . $pathinfo["filename"] . "-" . implode("x", $size) . "." . $pathinfo["extension"];
			if (file_exists($file)) {
				@unlink($file);
			}
		}
		@unlink($image_path . "/" . $pathinfo["basename"]);

		return true;
	}
}