import { isArray, isEmpty } from "lodash";

/**
 * At this time, please don't use other sizes because the thumbnail images 
 * will have dark bars on both top and bottom sides
 * @param {*} videoUrl 
 * @param {*} width 
 * @param {*} force 
 * @returns 
 */
export function getYoutubeThumbnail(videoUrl, width = 1400, force = false) {

    let videoId = '';


    if (
    videoUrl.indexOf('https://youtu.be/') === -1 && 
    videoUrl.indexOf('https://www.youtube.com/watch?v=') === -1
    ) {


        if (!force) {
            return '';
        }



        if (videoUrl.indexOf('https://img.youtube.com/vi/') === -1) {
            return '';
        }        
    }

    videoId = videoUrl.replace('https://youtu.be/', '').replace('https://www.youtube.com/watch?v=', '').replace('https://img.youtube.com/vi/', '');
    videoId = videoId.split('/')[0];
    videoId = videoId.split('&')[0];
    videoId = videoId.split('?')[0];
    videoId = videoId.split('#')[0];

    
    if (!videoId) {
        return '';
    }
    let size = getYouTubeThumbnailSize(width);


    const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/${size}.jpg`;

    return thumbnailUrl;
}

export function getYouTubeThumbnailSize(imageWidth) {
    if (imageWidth >= 1280) {
        return 'maxresdefault';
    } else if (imageWidth >= 640) {
        return 'sddefault';
    } else if (imageWidth >= 480) {
        return 'hqdefault';
    }
    return 'default';

}

export function getBlockText(textAttr) {
    if (!isArray(textAttr) || !textAttr.length) {
        return '';
    }

    let text = '';
    let localeText = '';
    for (let content of textAttr) {
        if (!content['slug'] || !content['value'] || content['disable']) {
            continue;
        }

        if (!text) {
            text = content['value'];
        }
        
        if (content['slug'] === dragBlockEditorInit.siteLocale) {
            localeText = content['value'];
            break;
        }
    }

    if (!localeText) {
        localeText = text;
    }

    return localeText;

}