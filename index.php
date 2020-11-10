<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="search">
        <form action="receive.php" id='search'>
            依日期尋找：<input type="date" name="date" id="date" value="<?=(!empty($_GET['date']))?$_GET['date']:''?>">
            幣別：<input type="text" name='currency' id='currency' value="<?=(!empty($_GET['currency']))?$_GET['currency']:''?>">
        </form>
    </div>
    <div id='status'>幣別狀態
        <div class="sczone">
            <?php
                session_start();
                include_once 'colName.php';
                $keys=array_keys($colsOfCurrency);
                foreach($_SESSION['lists'] as $k => $v){   ?>
                <div><?=$keys[$k]?><input type="checkbox" name="<?=$k+1?>" <?=$v['status']?'checked':''?>></div>
            <?php  }   ?>
        </div>
    </div>
    <div class="master">
    <table id='tt'>
        <tr>
            <td>幣別</td>
            <td>本行買入</td>
            <td>本行賣出</td>
            <td>本行買入</td>
            <td>本行賣出</td>
            <td>日期</td>
        </tr>
        <?php
            if(!empty($_SESSION['data'])){
            foreach($_SESSION['data'] as $row){
        ?>
        <tr id="c<?=$row['Currency_id']?>">
            <?php foreach($row as $key=> $col){   
                if($key != 'id' && $key!='Currency_id' && $key!='status'){  
                    if($key=='create_time'){
            ?>
                <td><?=mb_substr($col,0,10)?></td>
            <?php   }else{ ?>
                <td><?=$col?></td>
            <?php }  }  } ?>
        </tr>
        <?php } }?>
    </table>
        <form action="receive.php" method="post">
            <button>下載 Excell</button>
        </form>
    </div>
    
    <script>
        window.onload=()=>{
            let form=document.querySelector('#search');
            document.querySelector('#date').addEventListener('change',function(){
                form.submit()
            })
            document.querySelector('#currency').addEventListener('change',function(){
                form.submit()
            })
            list = document.querySelectorAll('.sczone div input')
            list.forEach(item=>item.addEventListener('click',changeStatus))
        }
        async function changeStatus(id){
            let target=document.querySelector(`#c${event.target.name}`)
            let data
            await fetch(`receive.php?id=${event.target.name}&date=${location.search.substr(location.search.indexOf('2020'),10)}`).then(res=>res.json()).then(res=>data=res).catch(err=>console.log(err))

            if(data=='remove'){
                target.remove()
            }else{
                append(data)
            }
        }
        function append(data){
            let table=document.querySelector('table')
            let name=['cur','cash_buy','cash_sell','redeposit_buy','redeposit_sell','create_time']
            let tr=document.createElement('tr')
            tr.id=`c${data.Currency_id}`
            for(let i =0;i<name.length;i++){
                let td=document.createElement('td')
                let text=document.createTextNode(data[name[i]])
                td.appendChild(text)
                tr.appendChild(td)
            }
            table.appendChild(tr)
        }
    </script>
</body>
</html>