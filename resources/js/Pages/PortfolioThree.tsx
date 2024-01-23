import { Head } from '@inertiajs/react';
import { OrbitControls, ScrollControls, Sky, Stars, StatsGl } from "@react-three/drei";
import { PageProps } from '@/types';
import { Canvas } from '@react-three/fiber';
import { Suspense, useEffect, useState } from 'react';
import Loader from '@/Components/Loader';
import { Bg } from '@/Components/Bg';
import { Overlay } from './Portfolio/Overlay';

export interface PortfolioTypes {
    id: number;
    is_use: number;
    title: string;
    subtitle: string;
    scroll_text: string;
    bio_title: string;
    bio_subtitle: string;
    skill_title: string;
    quote: string;
    quote_author: string;
    contact_links_title: string;
    is_using_default_contact_links: number;
    created_at: Date;
    updated_at: Date;
    skill_sets: ContactMeLink[];
    contact_me_links: ContactMeLink[];
}

export interface ContactMeLink {
    id: number;
    portfolio_id: number;
    title: string;
    link?: string;
    icon: string;
    created_at: Date;
    updated_at: Date;
}

export default function PortfolioThree({ portfolio }: PageProps<{ portfolio: PortfolioTypes }>) {
    const [isControlling, setIsControlling] = useState<boolean>(false);
    const [isShowStats, setIsShowStats] = useState<boolean>(false);
    const [isZooming, setIsZooming] = useState<boolean>(false);

    useEffect(() => {
        const divTouch = document.querySelector('canvas')?.nextElementSibling as HTMLElement;
        !isControlling && divTouch && divTouch.style.removeProperty('touch-action');
    }, [isControlling])

    return (
        <section id='3d'>
            <Head title="Jelvin Krisna Putra">
                <link rel="icon" type="image/svg+xml+ico" href="/assets/pictures/logo.png" />
            </Head>
            <nav className="absolute top-0 right-0 backdrop-blur-sm rounded m-5 gap-3 flex flex-col z-50">
                <a href={route('filament.app.pages.home-page')} type="button" className="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">More Apps</a>
                <label className="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" className="sr-only peer" onChange={_ => setIsShowStats(prev => !prev)} checked={isShowStats} />
                    <div className="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                    <span className="ml-3 text-sm font-medium text-white">Stats</span>
                </label>
                <label className="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" className="sr-only peer" onChange={_ => setIsControlling((prev: any) => {
                        prev && setIsZooming(false);
                        return !prev;
                    })} checked={isControlling} />
                    <div className="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-teal-300 dark:peer-focus:ring-teal-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-teal-600"></div>
                    <span className="ml-3 text-sm font-medium text-white">Control</span>
                </label>
                <label className="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" className="sr-only peer" onChange={_ => setIsZooming((prev: any) => {
                        !prev && setIsControlling(true);
                        return !prev;
                    })} checked={isZooming} />
                    <div className="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                    <span className="ml-3 text-sm font-medium text-white">Zoom</span>
                </label>
            </nav>
            <Canvas shadows camera={{ position: [0, 0, 8], zoom: 2 }} >
                {isShowStats && <StatsGl />}
                <Suspense fallback={<Loader />}>
                    <ambientLight intensity={1} />
                    <Stars radius={30} depth={50} count={1000} factor={4} saturation={1} fade speed={.3} />
                    {isControlling && (
                        <OrbitControls enableZoom={isZooming} autoRotate />
                    )}
                    <ScrollControls pages={5} damping={0.12}>
                        <Overlay portfolio={portfolio} />
                        <Bg />
                        <Sky sunPosition={[100, 20, 100]} distance={99999999} />
                        {/* <Environment preset='dawn' /> */}
                    </ScrollControls>
                </Suspense>
            </Canvas>


        </section>
    );
}
