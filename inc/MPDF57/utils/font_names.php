<?php

namespace Mpdf;

use Mpdf\Fonts\FontCache;

/**
 * This script examines your font directory.
 * By default this will examine the font directory defined by $mpdf->fontDir
 * You can optionally output just the font samples as a PDF file by setting $pdf=true.
 */

$pdf = false;

require_once '../vendor/autoload.php';

$mpdf = new Mpdf(['mode' => 's']);
$fontCache = new FontCache(new Cache($mpdf->fontTempDir));

$mpdf->useSubstitutions = true;

$ttfdir = $mpdf->fontDir;

$ttf = new TTFontFileAnalysis($fontCache, $mpdf->getFontDescriptor());

$tempfontdata = array();
$tempsansfonts = array();
$tempseriffonts = array();
$tempmonofonts = array();
$tempfonttrans = array();

$ff = scandir($ttfdir);

foreach ($ff as $f) {
	$ret = array();
	$isTTC = false;
	if (strtolower(substr($f, -4, 4)) == '.ttc' || strtolower(substr($f, -5, 5)) == '.ttcf') {    // Mac ttcf
		$isTTC = true;
		$ttf->getTTCFonts($ttfdir . '/' . $f);
		$nf = $ttf->numTTCFonts;
		for ($i = 1; $i <= $nf; $i++) {
			$ret[] = $ttf->extractCoreInfo($ttfdir . '/' . $f, $i);
		}
	} elseif (strtolower(substr($f, -4, 4)) == '.ttf' || strtolower(substr($f, -4, 4)) == '.otf') {
		$ret[] = $ttf->extractCoreInfo($ttfdir . '/' . $f);
	}
	for ($i = 0; $i < count($ret); $i++) {
		if (!is_array($ret[$i])) {
			if (!$pdf) {
				echo $ret[$i] . '<br />';
			}
		} else {
			$tfname = $ret[$i][0];
			$bold = $ret[$i][1];
			$italic = $ret[$i][2];
			$fname = strtolower($tfname);
			$fname = preg_replace('/[ ()]/', '', $fname);
			$tempfonttrans[$tfname] = $fname;
			$style = '';
			if ($bold) {
				$style .= 'B';
			}
			if ($italic) {
				$style .= 'I';
			}
			if (!$style) {
				$style = 'R';
			}
			$tempfontdata[$fname][$style] = $f;
			if ($isTTC) {
				$tempfontdata[$fname]['TTCfontID'][$style] = $ret[$i][4];
			}
			//if ($ret[$i][5]) { $tempfontdata[$fname]['rtl'] = true; }
			//if ($ret[$i][7]) { $tempfontdata[$fname]['cjk'] = true; }
			if ($ret[$i][8]) {
				$tempfontdata[$fname]['sip'] = true;
			}
			if ($ret[$i][9]) {
				$tempfontdata[$fname]['smp'] = true;
			}
			if ($ret[$i][10]) {
				$tempfontdata[$fname]['puaag'] = true;
			}
			if ($ret[$i][11]) {
				$tempfontdata[$fname]['pua'] = true;
			}
			if ($ret[$i][12]) {
				$tempfontdata[$fname]['unAGlyphs'] = true;
			}
			$ftype = $ret[$i][3];        // mono, sans or serif
			if ($ftype == 'sans') {
				$tempsansfonts[] = $fname;
			} elseif ($ftype == 'serif') {
				$tempseriffonts[] = $fname;
			} elseif ($ftype == 'mono') {
				$tempmonofonts[] = $fname;
			}
		}
	}
}

$tempsansfonts = array_unique($tempsansfonts);
$tempseriffonts = array_unique($tempseriffonts);
$tempmonofonts = array_unique($tempmonofonts);
$tempfonttrans = array_unique($tempfonttrans);

if (!$pdf) {
	echo '<h3>Information</h3>';
}

foreach ($tempfontdata as $fname => $v) {
	if (!isset($tempfontdata[$fname]['R']) || !$tempfontdata[$fname]['R']) {
		if (!$pdf) {
			echo 'WARNING - Font file for ' . $fname . ' may be an italic cursive script, or extra-bold etc.<br />';
		}
		if (isset($tempfontdata[$fname]['I']) && $tempfontdata[$fname]['I']) {
			$tempfontdata[$fname]['R'] = $tempfontdata[$fname]['I'];
		} elseif (isset($tempfontdata[$fname]['B']) && $tempfontdata[$fname]['B']) {
			$tempfontdata[$fname]['R'] = $tempfontdata[$fname]['B'];
		} elseif (isset($tempfontdata[$fname]['BI']) && $tempfontdata[$fname]['BI']) {
			$tempfontdata[$fname]['R'] = $tempfontdata[$fname]['BI'];
		}
	}
	if (isset($tempfontdata[$fname]['smp']) && $tempfontdata[$fname]['smp']) {
		if (!$pdf) {
			echo 'INFO - Font file ' . $fname . ' contains characters in Unicode Plane 1 SMP<br />';
		}
		$tempfontdata[$fname]['smp'] = false;
	}
	// if (isset($tempfontdata[$fname]['pua']) && $tempfontdata[$fname]['pua']) {
	// 	if (!$pdf) echo 'INFO - Font file '.$fname.' contains characters in Unicode Private Use Area (U+E000-U+F8FF)<br />';
	// }
	if (isset($tempfontdata[$fname]['unAGlyphs']) && $tempfontdata[$fname]['unAGlyphs']) {
		if (!$pdf) {
			echo 'INFO - Font file ' . $fname . ' contains non-indexed Arabic Glyphs "unAGlyphs" (which can be mapped to U+F500-U+F7FF)<br />';
		}
		if (isset($tempfontdata[$fname]['puaag']) && $tempfontdata[$fname]['puaag']) {
			if (!$pdf) {
				echo 'WARNING - Font file ' . $fname . ' already includes mapped characters in the part of Unicode Private Use Area which mPDF uses for mapping non-indexed Arabic Glyphs "unAGlyphs" (U+F500-U+F7FF)<br />';
			}
		}
	}
	if (isset($tempfontdata[$fname]['sip']) && $tempfontdata[$fname]['sip']) {
		if (!$pdf) {
			echo 'INFO - Font file ' . $fname . ' contains characters in Unicode Plane 2 SIP<br />';
		}
		if (preg_match('/^(.*)-extb/', $fname, $fm)) {
			if (isset($tempfontdata[($fm[1])]) && $tempfontdata[($fm[1])]) {
				$tempfontdata[($fm[1])]['sip-ext'] = $fname;
				if (!$pdf) {
					echo 'INFO - Font file ' . $fname . ' has been defined as a CJK ext-B for ' . ($fm[1]) . '<br />';
				}
			} elseif (isset($tempfontdata[($fm[1] . '-exta')]) && $tempfontdata[($fm[1] . '-exta')]) {
				$tempfontdata[($fm[1] . '-exta')]['sip-ext'] = $fname;
				if (!$pdf) {
					echo 'INFO - Font file ' . $fname . ' has been defined as a CJK ext-B for ' . ($fm[1] . '-exta') . '<br />';
				}
			}
		}
		// else { unset($tempfontdata[$fname]['sip']); }
	}
	unset($tempfontdata[$fname]['sip']);
	unset($tempfontdata[$fname]['smp']);
	unset($tempfontdata[$fname]['pua']);
	unset($tempfontdata[$fname]['puaag']);
	unset($tempfontdata[$fname]['unAGlyphs']);
}

$mpdf->fontdata = array_merge($tempfontdata, $mpdf->fontdata);

$mpdf->available_unifonts = array();
foreach ($mpdf->fontdata as $f => $fs) {
	if (isset($fs['R']) && $fs['R']) {
		$mpdf->available_unifonts[] = $f;
	}
	if (isset($fs['B']) && $fs['B']) {
		$mpdf->available_unifonts[] = $f . 'B';
	}
	if (isset($fs['I']) && $fs['I']) {
		$mpdf->available_unifonts[] = $f . 'I';
	}
	if (isset($fs['BI']) && $fs['BI']) {
		$mpdf->available_unifonts[] = $f . 'BI';
	}
}

$mpdf->default_available_fonts = $mpdf->available_unifonts;

if (!$pdf) {
	echo '<hr />';
	echo '<h3>Font names as parsed by mPDF</h3>';
}

ksort($tempfonttrans);
$html = '';
foreach ($tempfonttrans as $on => $mn) {
	if (!file_exists($ttfdir . '/' . $mpdf->fontdata[$mn]['R'])) {
		continue;
	}
	$ond = '"' . $on . '"';
	$html .= '<p style="font-family:' . $on . ';">' . $ond . ' font is available as ' . $mn;
	if (isset($mpdf->fontdata[$mn]['sip-ext']) && $mpdf->fontdata[$mn]['sip-ext']) {
		$html .= '; CJK ExtB: ' . $mpdf->fontdata[$mn]['sip-ext'];
	}
	$html .= '</p>';
}

if ($pdf) {
	$mpdf->WriteHTML($html);
	$mpdf->Output();
	exit;
}

foreach ($tempfonttrans as $on => $mn) {
	$ond = '"' . $on . '"';
	echo '<div style="font-family:\'' . $on . '\';">' . $ond . ' font is available as ' . $mn;
	if (isset($mpdf->fontdata[$mn]['sip-ext']) && $mpdf->fontdata[$mn]['sip-ext']) {
		echo '; CJK ExtB: ' . $mpdf->fontdata[$mn]['sip-ext'];
	}
	echo '</div>';
}
echo '<hr />';

echo '<h3>Sample fonts config</h3>';
echo '<div>Remember to edit the following arrays to place your preferred default first in order:</div>';

echo '<pre>';

ksort($tempfontdata);
echo '$this->fontdata = ' . var_export($tempfontdata, true) . ";\n";

sort($tempsansfonts);
echo '$this->sans_fonts = array(\'' . implode("', '", $tempsansfonts) . "');\n";
sort($tempseriffonts);
echo '$this->serif_fonts = array(\'' . implode("', '", $tempseriffonts) . "');\n";
sort($tempmonofonts);
echo '$this->mono_fonts = array(\'' . implode("', '", $tempmonofonts) . "');\n";
echo '</pre>';

exit;
