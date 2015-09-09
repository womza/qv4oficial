<?php


#-----------------------------------------------------------------#
# Button Shortocode
#-----------------------------------------------------------------#

function seattle_button($atts){
	extract( shortcode_atts( array(
		'href' => '#',
		'title' => 'Default button',
		'target' => '_self',
		'class' => 'default',
		'size' => '',
		'style' => ''
	), $atts, 'seattle_button' ) );
	return '
	<a href="'.$href.'" target="'.$target.'" class="btn btn-'.$class.' btn-'.$size.' btn-'.$style.'">'.$title.'</a>
';
}
add_shortcode('button', 'seattle_button');


#-----------------------------------------------------------------#
# Button Group Shortocode
#-----------------------------------------------------------------#

function seattle_button_group($atts, $content){
	extract( shortcode_atts( array(
		'href' => '#',
		'title' => 'Default button',
		'target' => '_self',
		'class' => 'default',
		'size' => '',
		'style' => ''
	), $atts, 'seattle_button_group' ) );
	return '
	<div class="btn-group">
	    <a href="javascript:void(0)" class="btn btn-'.$class.'">'.$title.'</a>
	    <a href="javascript:void(0)" data-target="#" class="btn btn-'.$class.' dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
	    <ul class="dropdown-menu">
	        '.do_shortcode($content).'
	    </ul>
	</div>
';
}
add_shortcode('button-group', 'seattle_button_group');



function seattle_button_group_item($atts, $content){
	extract( shortcode_atts( array(
		'href' => '#',
		'target' => '_self',
	), $atts, 'seattle_button_group_item' ) );
	return '
	        <li><a href="'.$href.'" target="'.$target.'">'.do_shortcode($content).'</a></li>
';
}
add_shortcode('button-group-item', 'seattle_button_group_item');


function seattle_button_group_divider($atts){
	extract( shortcode_atts( array(
	), $atts, 'seattle_button_group_divider' ) );
	return '
	        <li class="divider"></li>
';
}
add_shortcode('button-group-divider', 'seattle_button_group_divider');



#-----------------------------------------------------------------#
# Typography Shortocodes
#-----------------------------------------------------------------#

function seattle_h1($atts, $content){
	extract( shortcode_atts( array(
	), $atts, 'seattle_h1' ) );
	return '
	<h1>'.do_shortcode($content).'</h1>
';
}
add_shortcode('h1', 'seattle_h1');


function seattle_h2($atts, $content){
	extract( shortcode_atts( array(
	), $atts, 'seattle_h2' ) );
	return '
	<h2>'.do_shortcode($content).'</h2>
';
}
add_shortcode('h2', 'seattle_h2');


function seattle_h3($atts, $content){
	extract( shortcode_atts( array(
	), $atts, 'seattle_h3' ) );
	return '
	<h3>'.do_shortcode($content).'</h3>
';
}
add_shortcode('h3', 'seattle_h3');


function seattle_h4($atts, $content){
	extract( shortcode_atts( array(
	), $atts, 'seattle_h4' ) );
	return '
	<h4>'.do_shortcode($content).'</h4>
';
}
add_shortcode('h4', 'seattle_h4');


function seattle_h5($atts, $content){
	extract( shortcode_atts( array(
	), $atts, 'seattle_h5' ) );
	return '
	<h5>'.do_shortcode($content).'</h5>
';
}
add_shortcode('h5', 'seattle_h5');


function seattle_h6($atts, $content){
	extract( shortcode_atts( array(
	), $atts, 'seattle_h6' ) );
	return '
	<h6>'.do_shortcode($content).'</h6>
';
}
add_shortcode('h6', 'seattle_h6');

function seattle_lead($atts, $content){
	extract( shortcode_atts( array(
	), $atts, 'seattle_lead' ) );
	return '
	<p class="lead">'.do_shortcode($content).'</p>
';
}
add_shortcode('lead', 'seattle_lead');


#-----------------------------------------------------------------#
# Blockquote Shortocode
#-----------------------------------------------------------------#

function seattle_blockquote($atts, $content){
	extract( shortcode_atts( array(
		'source' => '',
		'direction' => '',
	), $atts, 'seattle_blockquote' ) );
	return '
	<blockquote class="'.$direction.'">
	    <p>'.do_shortcode($content).'</p>
	    <small>'.$source.'</small>
	</blockquote>
';
}
add_shortcode('blockquote', 'seattle_blockquote');

#-----------------------------------------------------------------#
# Breadcrumbs Shortocode
#-----------------------------------------------------------------#

function seattle_breadcrumb($atts, $content){
	extract( shortcode_atts( array(
		'source' => '',
		'direction' => '',
	), $atts, 'seattle_breadcrumb' ) );
	return '
	<ul class="breadcrumb">
	    '.do_shortcode($content).'
	</ul>
';
}
add_shortcode('breadcrumb', 'seattle_breadcrumb');

function seattle_breadcrumb_item($atts, $content){
	extract( shortcode_atts( array(
		'href' => '#',
		'target' => '_self',
	), $atts, 'seattle_breadcrumb_item' ) );
	return '
	<li><a href="'.$href.'">'.do_shortcode($content).'</a></li>
';
}
add_shortcode('breadcrumb-item', 'seattle_breadcrumb_item');

#-----------------------------------------------------------------#
# Alert Shortocode
#-----------------------------------------------------------------#

function seattle_alerts($atts, $content) {
    $atts = normalize_attributes($atts);
    $atts = shortcode_atts(array(
            'style' => 'default',
            'close' => false
        ), $atts);
     
    if (!$atts['close']) {
    	$style = $atts['style'];
        return '
		<div class="alert alert-'.$style.'">
		    <p>'.do_shortcode($content).'</p>
		</div>
    	';
    } else {
    	$style = $atts['style'];
        return '
        <div class="alert alert-dismissable alert-'.$style.'">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p>'.do_shortcode($content).'</p>
        </div>';
    }
}
add_shortcode('alert', 'seattle_alerts');

function normalize_attributes($atts) {
    foreach ($atts as $key => $value) {
        if (is_int($key)) {
            $atts[$value] = true;
            unset($atts[$key]);
        }
    }
     
    return $atts;
}

#-----------------------------------------------------------------#
# Label Shortocode
#-----------------------------------------------------------------#

function seattle_label($atts, $content){
	extract( shortcode_atts( array(
		'style' => '',
	), $atts, 'seattle_label' ) );
	return '
	<span class="label label-'.$style.'">'.do_shortcode($content).'</span>
';
}
add_shortcode('label', 'seattle_label');

#-----------------------------------------------------------------#
# Progress bars Shortocode
#-----------------------------------------------------------------#

function seattle_progress($atts){
	extract( shortcode_atts( array(
		'style' => '',
		'striped' => '',
		'value' => '',
		'animated' => '',
	), $atts, 'seattle_progress' ) );
	return '
	<div class="progress progress-'.$striped.' '.$animated.'">
	    <div class="progress-bar progress-bar-'.$style.'" style="width: '.$value.'%"></div>
	</div>
';
}
add_shortcode('progress', 'seattle_progress');

#-----------------------------------------------------------------#
# Jumbotron Shortocode
#-----------------------------------------------------------------#

function seattle_jumbotron($atts, $content){
	extract( shortcode_atts( array(
		'style' => '',
		'striped' => '',
		'value' => '',
		'animated' => '',
	), $atts, 'seattle_jumbotron' ) );
	return '
	<div class="jumbotron">
	    '.do_shortcode($content).'
	</div>
';
}
add_shortcode('jumbotron', 'seattle_jumbotron');

#-----------------------------------------------------------------#
# Panel Shortocode
#-----------------------------------------------------------------#

function seattle_panel($atts, $content){
	extract( shortcode_atts( array(
		'style' => 'default',
	), $atts, 'seattle_panel' ) );
	return '
	<div class="panel panel-'.$style.'">
	    '.do_shortcode($content).'
	</div>
';
}
add_shortcode('panel', 'seattle_panel');

function seattle_panel_header($atts, $content){
	extract( shortcode_atts( array(
		'style' => '',
	), $atts, 'seattle_panel_header' ) );
	return '
	<div class="panel-heading">
	    '.do_shortcode($content).'
	</div>
';
}
add_shortcode('panel-header', 'seattle_panel_header');

function seattle_panel_body($atts, $content){
	extract( shortcode_atts( array(
		'style' => '',
	), $atts, 'seattle_panel_body' ) );
	return '
	<div class="panel-body">'.do_shortcode($content).'</div>
';
}
add_shortcode('panel-body', 'seattle_panel_body');

function seattle_panel_footer($atts, $content){
	extract( shortcode_atts( array(
		'style' => '',
	), $atts, 'seattle_panel_footer' ) );
	return '
	<div class="panel-footer">
	    '.do_shortcode($content).'
	</div>
';
}
add_shortcode('panel-footer', 'seattle_panel_footer');

#-----------------------------------------------------------------#
# Wells Shortocode
#-----------------------------------------------------------------#

function seattle_well($atts, $content){
	extract( shortcode_atts( array(
		'size' => '',
	), $atts, 'seattle_well' ) );
	return '
	<div class="well well-'.$size.'">
	    '.do_shortcode($content).'
	</div>
';
}
add_shortcode('well', 'seattle_well');

#-----------------------------------------------------------------#
# Popovers Shortocode
#-----------------------------------------------------------------#

function seattle_popovers($atts, $content){
	extract( shortcode_atts( array(
		'style' => '',
		'placement' => 'top',
		'data_content' => '',
	), $atts, 'seattle_popovers' ) );
	return '
	<button type="button" class="btn btn-'.$style.'" data-container="body" data-toggle="popover" data-placement="'.$placement.'" data-content="'.$data_content.'">'.do_shortcode($content).'</button>
';
}
add_shortcode('popover', 'seattle_popovers');

#-----------------------------------------------------------------#
# Tooltips Shortocode
#-----------------------------------------------------------------#

function seattle_tooltips($atts, $content){
	extract( shortcode_atts( array(
		'style' => '',
		'placement' => 'top',
		'data_content' => '',
	), $atts, 'seattle_tooltips' ) );
	return '
	<button type="button" class="btn btn-'.$style.'" data-toggle="tooltip" data-placement="'.$placement.'" title="" data-original-title="'.$data_content.'">'.do_shortcode($content).'</button>
';
}
add_shortcode('tooltip', 'seattle_tooltips');

#-----------------------------------------------------------------#
# Rows and Columns Shortocode
#-----------------------------------------------------------------#

function seattle_rows($atts, $content){
	extract( shortcode_atts( array(
	), $atts, 'seattle_rows' ) );
	return '
	<div class="row">'.do_shortcode($content).'</div>
';
}
add_shortcode('row', 'seattle_rows');

function seattle_columns($atts, $content){
	extract( shortcode_atts( array(
		'large' => '',
		'medium' => '',
		'small' => '',
	), $atts, 'seattle_columns' ) );
	return '
	<div class="col-lg-'.$large.' col-md-'.$medium.' col-sm-'.$small.'">'.do_shortcode($content).'</div>
';
}
add_shortcode('column', 'seattle_columns');

#-----------------------------------------------------------------#
# Panel Shortocode
#-----------------------------------------------------------------#

function seattle_tabs( $params, $content=null ){
    $content = preg_replace( '/<br class="nc".\/>/', '', $content );
    $result = '<div class="tab_wrap">';
    $result .= do_shortcode( $content );
    $result .= '</div>';
    return force_balance_tags( $result );
}
add_shortcode( 'tabs', 'seattle_tabs' );

function seattle_thead( $params, $content=null) {
    $content = preg_replace( '/<br class="nc".\/>/', '', $content );
    $result = '<ul class="nav nav-tabs">';
    $result .= do_shortcode( $content );
    $result .= '</ul>';
    return force_balance_tags( $result );
}
add_shortcode( 'tab_head', 'seattle_thead' );

function seattle_tab( $params, $content=null ) {
    extract( shortcode_atts( array(
        'href' => '#',
        'title' => '',
        'class' => ''
        ), $params ) );
    $content = preg_replace( '/<br class="nc".\/>/', '', $content );
    $result = '<li class="' . $class . '">';
    $result .= '<a data-toggle="tab" href="' . $href . '">' . $title . '</a>';
    $result .= '</li>';
    return force_balance_tags( $result );
}
add_shortcode( 'tab', 'seattle_tab' );


function seattle_tcontents( $params, $content=null ) {
    $content = preg_replace( '/<br class="nc".\/>/', '', $content );
    $result = '<div class="tab-content">';
    $result .= do_shortcode( $content );
    $result .= '</div>';
    return force_balance_tags( $result );
}
add_shortcode( 'tab_contents', 'seattle_tcontents' );

function seattle_tcontent( $params, $content=null ) {
    extract(shortcode_atts(array(
        'id' => '',
        'class'=>'',
        ), $params ) );
    $content = preg_replace( '/<br class="nc".\/>/', '', $content );
    $class = ($class=='active')? 'active in': '';
    $result = '<div class="tab-pane ' . $class . '" id=' . $id . '>';
    $result .= do_shortcode( $content );
    $result .= '</div>';
    return force_balance_tags( $result );
}
add_shortcode( 'tab_content', 'seattle_tcontent' );