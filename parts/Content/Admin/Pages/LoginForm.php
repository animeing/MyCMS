<style>
.form{
    position: fixed;
}

.form > div{
    display: block;
    margin: 0 auto;
    padding: 40px;
    border: 1px solid #000;
    width: 500px;
    max-width: 70%;
    position: fixed;
    top: 50%;
    left: 50%;
    border-radius: 25px;
    transform: translateY(-50%) translateX(-50%);
    -webkit-transform: translateY(-50%) translateX(-50%);
}

.form input{
    min-width: calc(100% - 150px);
}

</style>
<?php
global $content;
?>
<form class="form" action="<?php echo CVV_VIEW_URL;?>" method="post">
    <div>
        <div><span class="title">USER&emsp;:&emsp;</span><input type="text" id="user" name="user" autocomplete="off" ></div>
        <div><span class="title">PASSWORD&emsp;:&emsp;</span><input type="password" id="pass" name="pass" autocomplete="off" ></div>
        <div><input type="submit" id="loginSubmit" value="Login"></div>
    </div>
</form>

<script>
    let login_submit = document.getElementById('loginSubmit');
    login_submit.addEventListener('click', ()=>{
        let username = document.getElementById('user').value;
        let password = document.getElementById('pass').value;
        
    });
</script>
