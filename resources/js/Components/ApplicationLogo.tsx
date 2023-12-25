import { ImgHTMLAttributes, SVGAttributes } from 'react';

export default function ApplicationLogo(props: ImgHTMLAttributes<HTMLImageElement>) {
    return (
        <img {...props} src="/assets/pictures/logo.ico" alt='Application Logo' />
    );
}
