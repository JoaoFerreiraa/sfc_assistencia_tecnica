<?php
if (isset($page)) {
    $path = "../relatorios/";
    echo '<link rel="stylesheet" href="./components/menuLateral.css">';
} else {
    echo '<link rel="stylesheet" href="../components/menuLateral.css">';
    $path = "../../relatorios/";
}



echo '<div class="painel bg-primary">'; ?>

<div class="items-painel-mobile">
    <label onclick="" id="btnMenu">
        <i class="fas fa-angle-right icon"></i>
    </label>
</div>

<?php
$diretorio = dir($path);

while ($arquivo = $diretorio->read()) {
    if (strpos($arquivo, '.') !== false) {
    } else {
        if ($arquivo !== "components") {
            echo '<a href="' . $path . $arquivo . '">
                <div class="items-painel">
                <i class="fas fa-angle-right"></i>
                    <span class="pl-1 item-painel-span">' . $arquivo . '</span>
                </div>
            </a>';
        }
    }
}
$diretorio->close();
?>
</div>
<?php
    if (isset($page)) {
        $path = "../relatorios/";
        echo '<script src="../../assets/js/jquery-3.5.1.js"></script>';
    } else {
        echo '<script src="../../../assets/js/jquery-3.5.1.js"></script>';
    }
?>


<script>
    let state = 0;
    $("#btnMenu").click(()=>{
        if(state === 0){
            $(".painel").css({width:"50vw"})
            $("#btnMenu").css({left: "40vw"})
            $("#btnMenu").css({transform: "rotate(180deg)"})
            $(".items-painel").css({display:"block"})
            state = 1;
        }else{
            $(".painel").css({width:"10vw"})
            $("#btnMenu").css({left: "2vw"})
            $("#btnMenu").css({transform: "rotate(0deg)"})
            $(".items-painel").css({display:"none"})
            

            state = 0;
        }
    })
</script>