const audio = $$("audio");
const progress = $$("#progress-range");
const sub_progress = $$('.slide__sub_progress');
const view_sub_progress = $$('.progress-block--timestamp');
const range__volume = $$("#range__volume");
const sub__volume = $$(".sub_process--volume");
const song__ifm = $$("#song__ifm");
const btn_playing = $$("#btn_playing");
const time__current = $$(".time__current");
const time__duration = $$(".time__duration");
const nextSong = $$(".nextSong");
const preSong = $$(".preSong");
const btn_random = $$(".btn_random");
const btn_repeat = $$(".btn_repeat");
const list_controllerBtn = $$l(".player__control-btn .control-btn");

const chatting = $$('#chatting')
const btn_Binhluan = $$('#btn_Binhluan')
if (!creatLocal('volume').getLocal()) {
    creatLocal('volume').setLocal(1);
}

musicPlayer(api, api[0].id);

function handChatting(comment) {
    comment = String(comment).replaceAll('<', '&lt;');
    comment = String(comment).replaceAll('>', '&gt;');
    return comment;
}

// lấy bình luận theo id
function getbinhluan(id) {
    localStorage.setItem('id_comment',id);
    let url = '/comment?action=getvalue&id=' + id;
    fetch(url).then(res => res.json())
        .then(data => {
            // lấy trên database
            $$(".list__user ul").innerHTML = renderComment(data);
            $$("#modal__comment").classList.toggle("hidden");
            $$(".modal__comment-container").classList.toggle("hidden");
        });
    btn_Binhluan.addEventListener('click', function () {
        if (!username) {
            toastMessage('Đăng nhập để bình luận');
            return 0;
        } else {
         
            let valuechat = handChatting(chatting.value);
     
            if(valuechat){
                let newid=  localStorage.getItem('id_comment');
                $.get('/comment', { action:"add",comment: valuechat, id: newid }, function (data) {
       
                    $$(".list__user ul").innerHTML = renderComment(data);
                })
            }
           
            chatting.value = '';
            let time = 10;
            btn_Binhluan.disabled = true;
            let id_times = setInterval(() => {
                btn_Binhluan.innerText = time + ' s';
                --time;
                if (time <= 0) {
                    btn_Binhluan.disabled = false;
                    btn_Binhluan.innerHTML = `<i class="fa-solid fa-share pe-1"></i> Gửi`;
                    clearInterval(id_times);

                }
            }, 1000)
        }
    })
    if (!username) {
        chatting.disabled = true;
    } else {
        chatting.disabled = false;
    }


}
function renderComment(binhluan) {
    let html = binhluan.map(comment => `
    <li>
    <div>
        <img src="${comment.avata}" alt="">
    </div>
    <div class="user__comment-ifm">
        <div>
            <user-name>${comment.username}</user-name> . <user-time>${comment.ngaytao}</user-time>
        </div>
        <p class="user-content">${comment.content}</p>
    </div>
</li>
    `).join('');
    if (html) return html;
    else return "No have comment";
}
//playmucisc when click
// truyền id music
function musicplayClick(id) {
    if (localStorage.getItem("layout") == "recent") {
        let newApi = JSON.parse(localStorage.getItem('playlistRecent'));
        musicPlayer(newApi, id);
    } else {
        musicPlayer(api, id);
    }
    $$("#btn_playing").click();

}

// playlist music singer
function musicSubArtists(idMusic, index) {
    creatLocal('musicArtists').setLocal(idMusic);
    musicPlayer(apiList, idMusic);
    $$("#btn_playing").click();
}

function getListAblums(id = 1) {
    serUrl('artists');
    let url = '/api/artist?id=' + id;
    fetch(url)
        .then(res => res.json())
        .then(data => {
            if (data.status == 200) {

                musicPlayList(data.singer, data.data);
                apiList = data.data;
                cleanActive($$l('.openMenuSub'), 'active');
                $$('.openMenuSub_artists').classList.add('active');
                addlistHidden($$l('.menu__leftsearch'), "hidden");
                $$("#sub_astists").classList.remove("hidden");
                $$("#id_astists").classList.add("hidden");
            }

        })

}
//
function playlistAlbums() {
    let newUrl=playlistORRecent("playlist");
    musicPlayer(newUrl[0], newUrl[1]); 
   audio.play();
    toastMessage("Đã bật chế độ phát danh sách");
}

function playlistRecent() {
    let newUrl=playlistORRecent("recent");
    musicPlayer(newUrl[0], newUrl[1]); 
   audio.play();
    toastMessage("Đã bật chế độ phát danh sách");
}
function playlistTrend() {
    let id = $$("#id_trends .playlists").getAttribute("data-id");
    musicPlayer(api, id);
    $$("#btn_playing").click();
}
//list recent or playlists
function playlistORRecent(namelocal) {
    let listPlaylist = creatLocal(namelocal).getLocal();
    let arrList = [];
    if (listPlaylist && typeof listPlaylist == "string") {
        listPlaylist = JSON.parse(listPlaylist);
    }
    if (!listPlaylist) arrList = [];
    else {
        listPlaylist.forEach(idPlaylist => {
            let song = api.find(song => song.id === idPlaylist)
            arrList.push(song);
        })

        localStorage.setItem("playlistRecent", JSON.stringify(arrList));
    }

    if (arrList.length > 0) {
      arrList.reverse();
        $$("#recent_playlist .recent__playlist--container").innerHTML = creatPlaylistcontainer(arrList, 2);
        if(audio.paused){
            musicPlayer(arrList, listPlaylist[listPlaylist.length-1]); 
        }else{
             stopWave(localStorage.getItem('idplayer'),false);
        }
        
        return [arrList,listPlaylist[listPlaylist.length-1]];
        
    } else {
        $$("#recent_playlist .recent__playlist--container").innerHTML = "Dont have anythings music";
    }
}
function coverday(value){
    if(value.includes('-')){
        let arr=value.split('-').reverse();
        return arr.map(day=>day).join('/');
    }
}
// list ablums của ca sĩ
function musicPlayList(singer, apiList) {
    creatLocal("history").reset();
    let html = '';
    $$('#sub_astists .sub_astists--avata').src = singer.avata;
    $$('#sub_astists .total_follows span').innerText = new Intl.NumberFormat().format(singer.totalListen);
    $$('#sub_astists .singer_des--subtitle span').innerText = coverday(singer.birthday);
    $$('#sub_astists .singer_des--fullname').innerText = singer.singer;
    $$('.sub_astists-_list__music').innerHTML = creatPlaylistcontainer(apiList, 1);
}

musicPlaylistToptrend();
function musicPlaylistToptrend() {
    title = `<h2>#Top Trend <span onclick="playlistTrend()" class="button_play"><i class="fa-solid fa-circle-play"></i></span></h2>`;
    $$("#id_trends").innerHTML = title + creatPlaylistcontainer(api, 3);
}
function creatPlaylistcontainer(apiList, kind) {
    let listPlaylist = (creatLocal('playlist').getLocal());
    let html = '';
    let topmusic = 0;
    html = apiList.map((song, index) => ` <div class="playlists" data-id="${song.id}">
    <div class="playlist--box__item d-flex-align-center-justify-between">
        <div onclick="${kind == 1 ? `musicSubArtists(${song.id},${index})` : `musicplayClick(${song.id})`}"
            class="playlist__singer d-flex-align-center-justify-between">
            <div class="playlist__song-rank">
                ${kind == 3 ? ++topmusic : `<i class="fa-solid fa-music"></i>`}
            </div>
            <div class="playlists__avata">
                <img src="${song.poster}" alt="">
                <div class="playlists__avata--wave">
                    <div class="playlists__avata--pause">
                        <i class="fa-solid fa-play"></i>
                    </div>
                    <div class="playlists__avata--playing hidden">
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </div>
                </div>
            </div>
            <div>
                <h2 class="playlist__singer-song m-0">${song.song}</h2>
                <p class="playlist__singer-name m-0">${song.singer}</p>
            </div>
        </div>
    </div>
    <div class="playlist__singer-time">
      ${song.time}
    </div>
    <div class="playlist__controller d-flex-align-center-justify-between">
        <div class="playlist__heart me-2">
        ${listPlaylist.includes(song.id) ? `<i onclick="removeIdplaylist(${song.id},this)" class="fa-solid fa-heart"></i>` : `<i onclick="getplaylist(${song.id},this)" class="fa-regular fa-heart"></i>`}     
        </div>
        <div class="playlist__option">
            <i class="fa-solid fa-ellipsis"></i>
            <div style="${ index==0 ? "top:0px":(index>=2 && apiList.length > 2)  ? "top:unset;" : ""}" class="playlist__option-box">
                <div class="option_box-song">
                    <div>
                        <img src="${song.poster}" alt="">
                    </div>
                    <div>
                        <h3 class="fs-6">${song.song}</h3>
                        <div class="fs-6">
                            <i class="fa-regular fa-heart"></i>
                            <span class="total_heart me-2">${makeupNumber(song.loves)}</span>
                            <i class="fa-solid fa-headphones"></i>
                            <span class="total_heart">${makeupNumber(song.listen)}</span>
                        </div>
                    </div>
                </div>
                <div class="option_box--controller">
                    <ul>
                        <li><a href="${song.link}" download><i class="fa-solid fa-download"></i> Tải
                                xuống</a>
                        </li>
                        <li onclick="musicplayClick(${song.id})"><a><i class="fa-solid fa-play"></i> Phát</a></li>
                        <li onclick=getplaylist(${song.id},this)><a><i class="fa-solid fa-plus"></i> Thêm vào Albums</a></li>
                        <li onclick="getbinhluan(${song.id})"><a><i class="fa-solid fa-comment"></i> Bình
                                Luận</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div> 
    `).join('');
    return html;
}
// phát nhạc theo trend
function musicArtists(Element, idMusic, index) {
    let playlists__avata = $$l("#id_trends .playlists__avata--pause");
    let playlists__wave = $$l("#id_trends .playlists__avata--playing");

    if (creatLocal('musicArtists').getLocal() != idMusic) {
        playlists__avata.forEach(item => { item.classList.remove("hidden") });
        playlists__wave.forEach(item => { item.classList.add("hidden") });
    }
    playlists__avata[index].classList.toggle("hidden");
    playlists__wave[index].classList.toggle("hidden");
    creatLocal('musicArtists').setLocal(idMusic);
    musicPlayer(api, idMusic);
    audio.play();
};

function cleanActive(listElement, classname) {
    Array.from(listElement).forEach(element => {
        element.classList.remove(classname);
    })
}
function addlistHidden(listElement, classname) {
    Array.from(listElement).forEach(element => {
        element.classList.add(classname);
    })
}

$$('#playmain_home').onclick = function () {
    if (this.innerHTML.includes("fa-play")) {
        this.innerHTML = 'Pause <i class="ms-2 fa-solid fa-pause"></i>';

    } else {
        this.innerHTML = 'Play Now <i class="ms-2 fa-solid fa-play"></i>';

    }
    $$("#btn_playing").click();
    let sss = `<i class="ms-2 fa-solid fa-pause"></i>`;
}

function musicPlayer(listsong, idMusic = 1) {

    const app = {
        currentId: idMusic,
        songs: listsong,
        time_duration: 0,
        isrepeat: false,
        israndom: false,
        volume: creatLocal('volume').getLocal(),
        isplaying: false,
        defineProperties: function () {
            Object.defineProperty(this, 'currentSong', {
                get: function () {
                    if(username){
                        $.get('/uploadview',{action:"listen",id:this.currentId});
                    }
                    return this.songs.find(song => song.id == this.currentId);
                }
            })
        },
        loadCurrentSong() {

            let musicImformation = this.currentSong;
            song__ifm.querySelector("img").src = musicImformation.poster;
            song__ifm.querySelector("marquee").innerText = musicImformation.song;
            song__ifm.querySelector(".song--des").innerText = musicImformation.singer;

            serUrl(musicImformation.song,"music");
            audio.src = musicImformation.link;
            audio.onloadeddata = () => {
                 progress.value = 0;
                time__duration.innerText = this.makeUptime(audio.duration);
                if(musicImformation.time!=this.makeUptime(audio.duration)){
                    $.get('/updatetime',{id:musicImformation.id,time:this.makeUptime(audio.duration)});
                }
             
            }
            sub_progress.style.width = '0%';
            range__volume.value = creatLocal('volume').getLocal();
            sub__volume.style.width = (creatLocal('volume').getLocal() * 100) + "%";
            creatLocal("history").setListLocal(Number(this.currentId));
            creatLocal("recent").setListLocal(Number(this.currentId));
            localStorage.setItem('idplayer',this.currentId);
            if (username) {
                $.get('/albums', { action: "recent", id: this.currentId })
            }

            if (creatLocal("history").getLocal() && creatLocal("history").getLocal().length >= this.songs.length) {
                creatLocal("history").reset();
            }
         
          
                if($$(".total_follows span")){
                  
                    let valuemusic=$$(".total_follows span").innerText;
                    if(valuemusic.includes('.')){
                        valuemusic=valuemusic.replaceAll('.','');
                    }
                    valuemusic=Number(valuemusic)+1;
                    // console.log(valuemusic);
                    $$(".total_follows span").innerText=  new Intl.NumberFormat().format(valuemusic);
                
               
              
            }
        },
        makeUptime(time) {
            let minute = Math.floor(time / 60);
            time -= minute * 60;
            let seconds = Math.floor(time);
            minute = minute > 9 ? minute : '0' + minute;
            seconds = seconds > 9 ? seconds : '0' + seconds;
            return `${minute}:${seconds}`;
        },
        handleEvent() {
            const _this = this;
            //Xử lý quay CD play / stop
            const cd_thumpAnimation = $$(".music__player--container  img").animate([
                { transform: 'rotate(359deg)' }], {
                duration: 10000, iterations: Infinity
            }
            )
            cd_thumpAnimation.pause();
            // sự kiện click phát nhạc
            btn_playing.onclick = function () {
                if (_this.isplaying) {
                    audio.pause();

                    stopWave(_this.currentId, true);
                    return true;
                } else audio.play();

                stopWave(_this.currentId, false);
            };

            audio.onplay = function () {
                _this.isplaying = true;
                cd_thumpAnimation.play();
                btn_playing.innerHTML = `<i class="fa-solid fa-circle-pause"></i>`;
                stopWave(_this.currentId, false);
            };
            audio.onpause = function () {
                _this.isplaying = false;
                cd_thumpAnimation.pause();

                btn_playing.innerHTML = `<i class="fa-solid fa-circle-play"></i>`;
            };

            let percent = (audio.currentTime / audio.duration) * 100;
            // audio.onloadeddata = () => {
            //     time__duration.innerText = this.makeUptime(audio.duration);
            //     percent = (audio.currentTime / audio.duration) * 100;
            // }
          

            // Tiến độ bài hát
            audio.addEventListener("timeupdate", function (e) {
                const duration_time = audio.duration;
                let current_time = audio.currentTime;
                let percent = ((current_time / duration_time) * 100).toFixed(2);
                if (percent) {
                    time__current.innerText = _this.makeUptime(current_time);
                    sub_progress.style.width = percent + '%';
                    progress.value = percent;
                }

            })
            let mouseClick = 0;

            progress.addEventListener('mousemove', function (e) {
                let lentMouseX = e.pageX;
                let lenpage = progress.getBoundingClientRect().x;
                let percentMouseMouse = (lentMouseX - lenpage);
                let lenpageWidth = progress.getBoundingClientRect().width;
                let percent_subview = (percentMouseMouse * 100 / lenpageWidth).toFixed(2);
                let music_percent = percent_subview * (audio.duration / 100)
                if (music_percent <= 0) music_percent = 0
                view_sub_progress.style.left = (percent_subview) + '%';
                view_sub_progress.innerText = _this.makeUptime(music_percent);
                mouseClick = music_percent;
               
            })

         
            progress.addEventListener('click', function (e) {
                // audio.currentTime=mouseClick;   
                toastMessage("Không thể kéo tới đoạn "+_this.makeUptime(mouseClick));
                console.log(_this.makeUptime(mouseClick)) ;
            })
            // Chỉnh âm lượng
            range__volume.onchange = function (e) {
                let measure_volume = e.target.value;
                setvolume(measure_volume);
                creatLocal('volume').setLocal(measure_volume);
                audio.volume = measure_volume;
                sub__volume.style.width = measure_volume * 100 + "%"
            }
            // next song
            nextSong.onclick = () => {
                if (_this.israndom) {
                    _this.playRandom();
                } else {
                    _this.nextSong();
                }
                audio.play();

            }
            // pre song
            preSong.onclick = () => {
                if (_this.israndom) {
                    _this.playRandom();
                } else {
                    _this.backSong();
                }
                audio.play();

            }
            // random song
            btn_random.onclick = () => {
                _this.israndom = !_this.israndom;
                if( _this.israndom) toastMessage("Đã bật chế độ phát ngẫu nhiên");
                else toastMessage("Đã tắt chế độ phát ngẫu nhiên");
                btn_random.classList.toggle("active", _this.isrepeat);
                this.playRandom();
                _this.isrepeat = false;
                btn_repeat.classList.remove("active");
            }
            // Repeat  song
            btn_repeat.onclick = () => {
                _this.isrepeat = !_this.isrepeat;
                btn_repeat.classList.toggle("active", _this.isrepeat);
                if( _this.israndom) toastMessage("Đã bật chế độ phát lặp lại");
                else toastMessage("Đã tắt chế độ phát lặp lại");
                btn_random.classList.remove("active");
                _this.israndom = false;
            }
            // video kết thúc
            audio.onended = () => {
                if (_this.israndom) {
                    _this.playRandom();
                    this.loadCurrentSong();
                    audio.play();
                }
                else if (_this.isrepeat) {
                    audio.play()
                } else {
                    nextSong.click();
                }
            }
            // event keyboard

            document.addEventListener('keydown', (e) => {
                if ($$('.modal__comment-container').className.includes('hidden') && !$$("#search").value && !$$("#explore_search").value) {
                    switch (e.keyCode) {
                        case 32:
                            btn_playing.click();
                            break;
                        case 38:
                        case 39:
                            if (btn_playing.querySelector('i').className.includes('pause')) {
                                _this.nextSong();
                                audio.play();
                                toastMessage("Phát bài tiếp theo");
                            }
                            break;
                        case 37:
                        case 40:
                            if (btn_playing.querySelector('i').className.includes('pause')) {
                                _this.backSong();
                                audio.play();
                                toastMessage("Phát bài  hát trước");
                            }

                            break;

                    }
                }

            })
        },
        nextSong() {
            let indexsss = this.songs.findIndex((song) => {
                return song.id == this.currentId;
            });
            if (indexsss + 1 >= this.songs.length) {
                this.currentId = this.songs[0].id
            } else {
                this.currentId = this.songs[indexsss + 1].id
            }
            this.loadCurrentSong();
        },
        backSong() {
            let indexsss = this.songs.findIndex((song) => {
                return song.id == this.currentId;
            });
            if (indexsss <= 0) {
                this.currentId = this.songs[this.songs.length - 1].id
            } else {
                this.currentId = this.songs[indexsss - 1].id
            }
            this.loadCurrentSong();

        },
        playRandom() {
            var index_random;
            let listId = this.songs.map(song => song.id);
            let history = [];
            if (creatLocal("history").getLocal()) {
                history = creatLocal("history").getLocal();
            }
            do {
                index_random = listId[Math.floor(Math.random() * listId.length)];
            } while (history.includes(index_random))
            this.currentId = index_random;
            if (this.israndom) btn_random.classList.add("active");
        },

        render() {

        },
        start() {
            this.defineProperties();
            this.handleEvent();
            this.loadCurrentSong();
            this.render();
        }
    }
    app.start();
    const chuyennhac = () => { app.nextSong() };

}

function stopWave(idMusic, ischose = false) {
    const listPlaylists = $$l(".playlists .playlists__avata--playing");
    const playlists__avata = $$l(".playlists .playlists__avata--pause");
    playlists__avata.forEach(item => { item.classList.remove("hidden") });
    listPlaylists.forEach(item => { item.classList.add('hidden') })
    if (ischose) return true;
    const playlists = $$l('.playlists');
    playlists.forEach(element => {
        if (element.getAttribute('data-id') == idMusic) {
            element.querySelector(".playlists__avata--playing").classList.remove('hidden');
            element.querySelector(".playlists__avata--pause").classList.add('hidden');;
        }
    })
}
setvolume(localStorage.getItem('volume'));
progress.value=0;
function setvolume(value){
    if(value<=0){
        $$('.change__kindof--volumn').innerHTML=`<i class="fa-solid fa-volume-xmark"></i>`;
    }else if(value<0.6){
        $$('.change__kindof--volumn').innerHTML=`     <i class="fa-solid fa-volume-low"></i>`;          
    }
    else{
        $$('.change__kindof--volumn').innerHTML=`<i class=" fa-solid fa-volume-high"></i>`;
       
    }
}