let showExplore = document.querySelector('#explore');
let findSong = document.querySelector("#find-song");

showExplore.addEventListener('click', function() {
    // hiện trang Explore
    let pageExplore = document.querySelector("#box-explore");
    pageExplore.classList.remove('hidden');
});

// tìm kiếm nhạc tại trang Explore
$$("#explore_search--btn").onclick=()=>{
    $$("#explore_search").focus();
}
$$("#explore_search").addEventListener("input", (e)=>{
    let valueSearch=e.target.value.trim().toLowerCase();
    if(valueSearch){
        let newApi=api.filter(item=> (item.song.toLowerCase().includes(valueSearch) || item.singer.toLowerCase().includes(valueSearch)));
        if(newApi.length>0){
            $$("#explore__container").innerHTML=creatPlaylistcontainer(newApi,2);
        }
    }else{
        $$("#explore__container").innerHTML="";
    }
  
})
//End tìm kiếm nhạc tại trang Explore

findSong.addEventListener('click', function() {
    // ẩn thông báo tìm nhạc
    let contentExplore = document.querySelector('#in-content-explore');
    contentExplore.classList.add('hidden');
    // thêm class có thuộc tính css mới cho box 
    let resetBoxExplore = document.querySelector('#content-page-explore');
    resetBoxExplore.classList.add('atc-second-page');
    // remove class hidden cho danh sách nhạc
    let listSong = document.querySelector('#subexplore');
    listSong.classList.remove('hidden');
});