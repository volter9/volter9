<div class="epic-header full"
     id="pomidorko"
     style="background-color: #ED4455; padding-bottom: 40px;">

<?php echo $theme->partial('blocks/navigation.jade', array_merge($__data__, [
    'classes' => 'navigation-white'
])) ?> 
    
    <div class="fluid">
        <h1 class="epic-header-title">
            <?php echo $title ?> 
        </h1>
    </div>
    
    <div class="pa-timer adaptive clearfix">
        <div class="pa-left-block">
            <div class="pa-timer-time">
                <span class="pa-min">00</span>
                <span class="pa-colon">:</span>
                <span class="pa-sec">00</span>
            </div>
        
            <div class="pa-timer-control pa-play">
                <span class="pa-icon pa-play"></span>
            </div>
            
            <div class="pa-skip">
                <span>Пропустить</span>
            </div>
        </div>
        
        <div class="pa-timer-scale pa-right-block">
            <div class="pa-timer-wrapper">
                <img srcset="<?php echo $url->make('assets/uploads/pomidorko/img/scale@2x.png') ?> 2x"
                     src="<?php echo $url->make('assets/uploads/pomidorko/img/scale.png') ?>"
                     alt="Шкала времени">
            </div>
        </div>
    </div>
</div>