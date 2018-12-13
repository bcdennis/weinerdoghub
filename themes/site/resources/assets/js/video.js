class Video {

    constructor(jquery, selector = 'video') {
        this.jquery = jquery;
        this.selector = selector;

        this.init();
    }

    init() {
        this.jquery('.posts,.post').on('click', '.has-video', this.toggleVideo);
    }

    toggleVideo() {
        var wrapper = $(this),
            video = wrapper.find('video')[0];

        if ( ! video.paused) {
            video.pause();
            wrapper.addClass('gif');
        } else {
            video.play();
            wrapper.removeClass('gif');
        }
    }
}

module.exports = Video;