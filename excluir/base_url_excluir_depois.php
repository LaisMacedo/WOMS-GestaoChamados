<link rel="stylesheet" href="croppie.css" />
<script src="croppie.js"></script>


<div class="upload-demo-wrap">
    <div id="upload-demo" class="croppie-container"><div class="cr-boundary" aria-dropeffect="none"><canvas class="cr-image" alt="preview" aria-grabbed="false" width="502" height="502" style="transform: translate3d(-100.996px, -100.997px, 0px) scale(0.1992); transform-origin: 250.996px 250.997px 0px; opacity: 1;"></canvas><div class="cr-viewport cr-vp-circle" tabindex="0" style="width: 100px; height: 100px;"></div><div class="cr-overlay" style="width: 99.9984px; height: 99.9985px; top: 100.001px; left: 100.002px;"></div></div><div class="cr-slider-wrap"><input class="cr-slider" type="range" step="0.0001" aria-label="zoom" min="0.1992" max="1.5000" aria-valuenow="0.1992"></div></div>
</div>


<script type="text/javascript">
    $uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 200,
        type: 'circle'
    },
    boundary: {
        width: 300,
        height: 300
    }
});

</script>>