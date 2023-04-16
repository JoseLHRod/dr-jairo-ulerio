<?php

defined('BASEPATH') or exit('No direct script access allowed');
$dimensions = $pdf->getPageDimensions();

$pdf_logo_url = pdf_logo_url();
$pdf->writeHTMLCell(($dimensions['wk'] - ($dimensions['rm'] + $dimensions['lm'])), '', '', '', $pdf_logo_url, 0, 1, false, true, 'L', true);

$pdf->ln(4);
// Get Y position for the separation
$y = $pdf->getY();

$proposal_info = '<div style="color:#424242;">';
    $proposal_info .= format_organization_info();
$proposal_info .= '</div>';

$pdf->writeHTMLCell(($swap == '0' ? (($dimensions['wk'] / 2) - $dimensions['rm']) : ''), '', '', ($swap == '0' ? $y : ''), $proposal_info, 0, 0, false, true, ($swap == '1' ? 'R' : 'J'), true);

$rowcount = max([$pdf->getNumLines($proposal_info, 80)]);

// Proposal to
$client_details = '<b>' . _l('proposal_to') . '</b>';
$client_details .= '<div style="color:#424242;">';
    $client_details .= format_proposal_info($proposal, 'pdf');
$client_details .= '</div>';

$pdf->writeHTMLCell(($dimensions['wk'] / 2) - $dimensions['lm'], $rowcount * 7, '', ($swap == '1' ? $y : ''), $client_details, 0, 1, false, true, ($swap == '1' ? 'J' : 'R'), true);

$pdf->ln(6);

$proposal_date = _l('proposal_date') . ': ' . _d($proposal->date);
$open_till     = '';

if (!empty($proposal->open_till)) {
    $open_till = _l('proposal_open_till') . ': ' . _d($proposal->open_till) . '<br />';
}

$qty_heading = _l('estimate_table_quantity_heading', '', false);

if ($proposal->show_quantity_as == 2) {
    $qty_heading = _l($this->type . '_table_hours_heading', '', false);
} elseif ($proposal->show_quantity_as == 3) {
    $qty_heading = _l('estimate_table_quantity_heading', '', false) . '/' . _l('estimate_table_hours_heading', '', false);
}

// The items table
$items = get_items_table_data($proposal, 'proposal', 'pdf')
        ->set_headings('estimate');

$items_html = $items->table();

$items_html .= '<br /><br />';
$items_html .= '';
$items_html .= '<table cellpadding="6" style="font-size:' . ($font_size + 4) . 'px">';

$items_html .= '
<tr>
    <td align="right" width="85%"><strong>' . _l('estimate_subtotal') . '</strong></td>
    <td align="right" width="15%">' . app_format_money($proposal->subtotal, $proposal->currency_name) . '</td>
</tr>';

if (is_sale_discount_applied($proposal)) {
    $items_html .= '
    <tr>
        <td align="right" width="85%"><strong>' . _l('estimate_discount');
    if (is_sale_discount($proposal, 'percent')) {
        $items_html .= '(' . app_format_number($proposal->discount_percent, true) . '%)';
    }
    $items_html .= '</strong>';
    $items_html .= '</td>';
    $items_html .= '<td align="right" width="15%">-' . app_format_money($proposal->discount_total, $proposal->currency_name) . '</td>
    </tr>';
}

foreach ($items->taxes() as $tax) {
    $items_html .= '<tr>
    <td align="right" width="85%"><strong>' . $tax['taxname'] . ' (' . app_format_number($tax['taxrate']) . '%)' . '</strong></td>
    <td align="right" width="15%">' . app_format_money($tax['total_tax'], $proposal->currency_name) . '</td>
</tr>';
}

if ((int)$proposal->adjustment != 0) {
    $items_html .= '<tr>
    <td align="right" width="85%"><strong>' . _l('estimate_adjustment') . '</strong></td>
    <td align="right" width="15%">' . app_format_money($proposal->adjustment, $proposal->currency_name) . '</td>
</tr>';
}
$items_html .= '
<tr style="background-color:#f0f0f0;">
    <td align="right" width="85%"><strong>' . _l('estimate_total') . '</strong></td>
    <td align="right" width="15%">' . app_format_money($proposal->total, $proposal->currency_name) . '</td>
</tr>';
$items_html .= '</table>';

if (get_option('total_to_words_enabled') == 1) {
    $items_html .= '<br /><br /><br />';
    $items_html .= '<strong style="text-align:center;">' . _l('num_word') . ': ' . $CI->numberword->convert($proposal->total, $proposal->currency_name) . '</strong>';
}

$proposal->content = str_replace('{proposal_items}', $items_html, $proposal->content);

// Get the proposals css
// Theese lines should aways at the end of the document left side. Dont indent these lines
$html = <<<EOF
<p style="font-size:20px;"># $number
<br /><span style="font-size:15px;">$proposal->subject</span>
</p>
$proposal_date
<br />
$open_till
<div style="width:675px !important;">
$proposal->content
</div>
EOF;

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->writeHTML('<div style="font-size: 14px;color: #111111;">Terms and Conditions</div>', true, false, true, false, '');
$pdf->ln(1);
$pdf->writeHTML('<div style="font-size: 12px;color: #404040;">By paying this deposit, you not only lock in your date, you "lock in" your quoted price. This value is deducted from the total quoted and is refundable only if the surgery is canceled by Dr. Jairo Ulerio. If the patient presents any health condition before the surgery, which contraindicates its performance (anemia, fever, illness in any sense, etc.), the deposit will be used to reserve a new date in which the patient has recovered. This deposit will be forfeited if the date is changed or canceled less than fourteen (14) days in advance. In case of having to reschedule her surgery, the patient has the right to two (2) changes, always with a minimum anticipation of fourteen (14) days and the new date must be within the range of twelve (12) months counted from the date the deposit was made.</div>', true, false, true, false, '');
$pdf->ln(2);
$pdf->writeHTML('<div style="font-size: 14px;color: #111111;">Términos y Condiciones</div>', true, false, true, false, '');
$pdf->ln(1);
$pdf->writeHTML('<div style="font-size: 12px;color: #404040;">Pagando este depósito, no solo resguarda su fecha, sino que "congela" su precio cotizado. Este valor es deducido del total cotizado y es reembolsable solo si la cirugía es cancelada por el Dr. Jairo Ulerio. Si el paciente presenta alguna condición de salud antes de la cirugía, que contraindique su ejecución (anemia, fiebre, enfermedad en cualquier sentido, etc.) el depósito será usado para reservar una nueva fecha donde el paciente se haya recuperado. Este depósito se perderá si la fecha es cambiada o cancelada con catorce (14) días menos de antelación. En caso de tener que reprogramar su cirugía, la paciente tiene derecho a dos (2) cambios, siempre con al menos catorce (14) días de anticipación y, la nueva fecha, debe estar dentro del rango de doce (12) meses desde la fecha que se realizó el depósito.</div>', true, false, true, false, '');
