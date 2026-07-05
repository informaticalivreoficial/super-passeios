export default () => ({
    opened:false,
    images:[],
    current:0,

    init(){
        window.addEventListener('keydown',(e)=>{
            if(!this.opened) return;
            switch(e.key){
                case 'ArrowRight':
                    this.next();
                    break;
                case 'ArrowLeft':
                    this.prev();
                    break;
                case 'Escape':
                    this.close();
                    break;
            }
        });
    },
    open(images,index){
        this.images=images;
        this.current=index;
        this.opened=true;
        document.body.classList.add('overflow-hidden');
    },
    close(){
        this.opened=false;
        document.body.classList.remove('overflow-hidden');
    },
    next(){
        this.current++;
        if(this.current>=this.images.length){
            this.current=0;
        }
        this.scrollThumbnail();
    },
    prev(){
        this.current--;
        if(this.current<0){
            this.current=this.images.length-1;
        }
        this.scrollThumbnail();
    },
    scrollThumbnail(){
        this.$nextTick(()=>{
            const thumbs=document.querySelectorAll('[x-for] img');
            if(thumbs[this.current]){
                thumbs[this.current].scrollIntoView({
                    behavior:'smooth',
                    inline:'center',
                    block:'nearest'
                });
            }
        });
    }
});