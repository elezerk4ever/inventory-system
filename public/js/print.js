window.print();
window.onafterprint = function(){
    history.go(-1);
};