<?php
include_once(PBD_SA_PATH_INCLUDES . '/tcpdf/tcpdf.php');
$w = "200";
$pdf_unit = "mm";
$pdf_page_orientation = "p"; // Portrait p or Landscape l
$pageLayout = array($w, $w); //  or array($height, $width) 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);

function set_font($pdf, $weight, $size){
    switch ($weight) {
        case 300:
            $font_weight =  "Rubik-Light.ttf";
            break;
        case 400:
            $font_weight =  "Rubik-Regular.ttf";
            break;
        case 500:
            $font_weight =  "Rubik-Medium.ttf";
            break;
        case 600:
            $font_weight =  "Rubik-SemiBold.ttf";
            break;
        case 700:
            $font_weight =  "Rubik-Bold.ttf";
            break;
        default:
            $font_weight =  "Rubik-Bold.ttf";
    }
    $pdf->SetFont(TCPDF_FONTS::addTTFfont(PBD_SA_PATH_INCLUDES.'/templates/fonts/'.$font_weight, 'TrueTypeUnicode', '', 96), '', $size, '', false);
}

function adjustImageAspectRatio($imageUrl, $newWidth) {
    list($originalWidth, $originalHeight) = getimagesize($imageUrl);
    $aspectRatio = $originalWidth / $originalHeight;
    $newHeight = $newWidth / $aspectRatio;
    return array(
        'originalWidth' => $originalWidth,
        'originalHeight' => $originalHeight,
        'newWidth' => $newWidth,
        'newHeight' => $newHeight
    );
}

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(0, 0, 0, true);
$pdf->SetAutoPageBreak(false, 0);

// page 1
$pdf->AddPage();
set_font($pdf,'700','30');
$pdf->Image((get_field('cover_image'))? get_field('cover_image') : PBD_SA_PATH_INCLUDES.'/templates/img/pdf-bg.jpg', 0, 0, 1080, 1080, 'JPG', '', '', true, 200, '', false, false, 0, false, false, true);
$html = '<h1 style="text-align:center;color:#fff;">'.get_field('heading').'</h1>';
$pdf->writeHTMLCell(0, $h, 0, 35, $html, $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);
set_font($pdf,'300','10');
$html = '<p style="text-align:center;color:#fff;">'.get_field('description').'</p>';
$pdf->writeHTMLCell(0, $h, 0, 65.814583333, $html, $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);

// page 2
$pdf->AddPage();
$pdf->Image(PBD_SA_PATH_INCLUDES.'/templates/img/pdf-bg-section2.jpg', 0, 0, 1080, 197, 'JPG', '', '', false, 300, '', false, false, 0, false, false, true);
$pdf->Image(PBD_SA_PATH_INCLUDES.'/templates/img/pdf-border.png', 255.69791667, 17.08125, 75, 16.758333333, 'PNG', '', '', false, 300, '', false, false, 0, false, false, true);
set_font($pdf,'700','20');
$html = '<h1 style="text-align:left;color:#fff;">Hi '.$_GET['name'].'</h1>';
$pdf->writeHTMLCell(0, $h, 15, 8, $html, $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);
set_font($pdf,'300','10');
$html = '<p style="text-align:left;line-height:24px;color:#fff;">Here is a personalized career transition action plan just for you!</p>';
$pdf->writeHTMLCell(0, $h, 15, 16, $html, $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);
set_font($pdf,'600','15');
$html = '<p style="line-height: 32px;color: #FFCC33;">'.get_field('estimated_months').'</p>';
$pdf->writeHTMLCell(0, $h, 155, 8, $html, $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);
set_font($pdf,'400','6');
$html = '<p style="color:#fff;">Estimated Months-To-Job (MT J) *</p>';
$pdf->writeHTMLCell(0, $h, 153, 18, $html, $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);
set_font($pdf,'400','10');
$html = get_field('estimated_description');
$pdf->writeHTMLCell(175, $h, 15, 50, $html, $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);


// Add pages
$repeater_field = get_field('add_page');
if ($repeater_field) {
    foreach ($repeater_field as $row) {
        $pdf->AddPage();
        $flexible_content_value = $row['content_type'];
        if($row['footer_type'] == 'Default'){
            $pdf->Image(PBD_SA_PATH_INCLUDES.'/templates/img/pdf-bg-section3.jpg', 0, 0, 1080, 33, 'JPG', '', '', false, 300, '', false, false, 0, false, false, true);
            $pdf->Image(PBD_SA_PATH_INCLUDES.'/templates/img/pdf-bg-section4.jpg', 0, 193.8, 1080, 33, 'JPG', '', '', false, 300, '', false, false, 0, false, false, true);
        }else{
            $pdf->Image(PBD_SA_PATH_INCLUDES.'/templates/img/pdf-bg-section3.jpg', 0, 0, 1080, 33, 'JPG', '', '', false, 300, '', false, false, 0, false, false, true);
            $pdf->Image(PBD_SA_PATH_INCLUDES.'/templates/img/pdf-video-footer-bg.jpg', 0, 160.3, 1080, 214, 'JPG', '', '', false, 300, '', false, false, 0, false, false, true); 
            if($row['customize_footer_title']){
                set_font($pdf,'600','12');
                $pdf->writeHTMLCell(50, 0, 15, 165, '<span style="color:#fff;">'.$row['customize_footer_title'].'</span>', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);
            }
            if($row['customize_footer_description']){
                set_font($pdf,'400','9');
                $pdf->writeHTMLCell(50, 0, 15, 178, '<span style="color:#fff;">'.$row['customize_footer_description'].'</span>', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);
            }
            if($row['customize_footer_profiles']){
                foreach($row['customize_footer_profiles'] as $profile){
                    if($profile['profile_image']){
                        $imagePath = $profile['profile_image'];
                        $link_yt = $profile['link'];
                        $imageDimensions = adjustImageAspectRatio($imagePath, '17%');
                        $imageType = exif_imagetype($imagePath);
                        if ($imageType === IMAGETYPE_JPEG) {
                            $mimeType = 'JPG';
                        } elseif ($imageType === IMAGETYPE_PNG) {
                            $mimeType = 'PNG';
                        }
                        $pdf->Image($imagePath, $profile['position_x'], $profile['position_y'], $imageDimensions['newWidth'], $imageDimensions['newHeight'], $mimeType, $link_yt);
                        set_font($pdf,'500','9');
                        $title_pos_y = intval($profile['position_y'])+18;
                        $title_pos_x = intval($profile['position_x'])-5;
                        $pdf->writeHTMLCell(30, 0, $title_pos_x, $title_pos_y, '<span style="color:#fff;text-align:center;">'.$profile['name'].'</span>', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);
                        set_font($pdf,'400','7');
                        $desc_pos_y = intval($title_pos_y)+5;
                        $desc_pos_x = intval($title_pos_x)+2;
                        $pdf->writeHTMLCell(25, 0, $desc_pos_x, $desc_pos_y, '<span style="color:#fff;text-align:center;">'.$profile['position'].'</span>', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);
                    }
                }   
            }
        }
        if ($flexible_content_value) {
            foreach ($flexible_content_value as $layout) {
                $content_layout = $layout['acf_fc_layout'];
                if($content_layout == 'heading'){
                    set_font($pdf,'700','15');
                    $html = '<p style="color: #342A82;">'.$layout['heading'].'<p>';
                    $pdf->writeHTMLCell(175, 0, $layout['position_x'], $layout['position_y'], $html, $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);
                }
                if($content_layout == 'description'){
                    set_font($pdf,'400','10');
                    $pdf->writeHTMLCell(175, 0, $layout['position_x'], $layout['position_y'], $layout['description'], $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true);
                }
                if($content_layout == 'image'){
                    $imagePath = $layout['image'];
                    $size = ($layout['image_size'] == 'Auto') ? '70%' : '170';
                    $imageDimensions = adjustImageAspectRatio($imagePath, $size);
                    $imageType = exif_imagetype($imagePath);
                    if ($imageType === IMAGETYPE_JPEG) {
                        $mimeType = 'JPG';
                    } elseif ($imageType === IMAGETYPE_PNG) {
                        $mimeType = 'PNG';
                    }  
                    $pdf->Image($layout['image'], $layout['position_x'], $layout['position_y'], $imageDimensions['newWidth'], $imageDimensions['newHeight'], $mimeType, '');
                }
                if($content_layout == 'button'){
                    $imagePath = $layout['button_image'];
                    $link = $layout['button_link'];
                    $imageDimensions = adjustImageAspectRatio($imagePath, '70%');
                    $imageType = exif_imagetype($imagePath);
                    if ($imageType === IMAGETYPE_JPEG) {
                        $mimeType = 'JPG';
                    } elseif ($imageType === IMAGETYPE_PNG) {
                        $mimeType = 'PNG';
                    }
                    $pdf->Image($imagePath, $layout['position_x'], $layout['position_y'], $imageDimensions['newWidth'], $imageDimensions['newHeight'], $mimeType, $link);
                }
                if($content_layout == 'youtube_thumbnail'){
                    $imagePath = $layout['thumbnail_image'];
                    $link_yt = $layout['link'];
                    $imageDimensions = adjustImageAspectRatio($imagePath, '52%');
                    $imageType = exif_imagetype($imagePath);
                    if ($imageType === IMAGETYPE_JPEG) {
                        $mimeType = 'JPG';
                    } elseif ($imageType === IMAGETYPE_PNG) {
                        $mimeType = 'PNG';
                    }
                    $pdf->Image($imagePath, $layout['position_x'], $layout['position_y'], $imageDimensions['newWidth'], $imageDimensions['newHeight'], $mimeType, $link_yt);
                }
            }
        }
    }
}
$pdf->Output('output.pdf', 'I');