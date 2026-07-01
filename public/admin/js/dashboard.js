
document.addEventListener('DOMContentLoaded', function(){

    const switchBtn = document.getElementById('themeSwitch');
    const label = document.getElementById('themeLabel');

    if(localStorage.getItem('theme') === 'light'){
        document.body.classList.add('light-mode');
        switchBtn.checked = true;
        label.innerText = 'Dark Mode';
    }

    switchBtn.addEventListener('change', function(){

        document.body.classList.toggle('light-mode');

        if(document.body.classList.contains('light-mode')){
            localStorage.setItem('theme', 'light');
            label.innerText = 'Dark Mode';
        }else{
            localStorage.setItem('theme', 'dark');
            label.innerText = 'Light Mode';
        }

    });

});
