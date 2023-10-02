import { Link, Head } from '@inertiajs/react';
import { Box, Environment, OrbitControls, ScrollControls, Sky, Sparkles, SpotLight, Stars, StatsGl } from "@react-three/drei";
import { PageProps } from '@/types';
import { Canvas } from '@react-three/fiber';
import { Overlay } from './Portfolio/Overlay';
import { BG } from '@/Components/BG';
import { Suspense, useEffect, useState } from 'react';
import Loader from '@/Components/Loader';
import MyBG from '@/Components/MyBG';

export default function Welcome({ auth, laravelVersion, phpVersion }: PageProps<{ laravelVersion: string, phpVersion: string }>) {
    const [isControlling, setIsControlling] = useState<boolean>(true);
    const [isShowStats, setIsShowStats] = useState<boolean>(false);
    const [isZooming, setIsZooming] = useState<boolean>(false);

    return (
        <>
            <Head title="Welcome" />
            <Canvas shadows camera={{ position: [0, 0, 8], zoom: 2 }} >
                {isShowStats && <StatsGl />}
                <Suspense fallback={<Loader />}>
                    <ambientLight intensity={1} />
                    <Stars radius={30} depth={50} count={1000} factor={4} saturation={1} fade speed={.3} />
                    {/* <Sparkles
                        color="orange"
                        count={1000}
                        noise={1}
                        opacity={.3}
                        speed={0.3}
                    /> */}
                    {isControlling && (
                        <OrbitControls enableZoom={isZooming} autoRotate />
                    )}
                    <ScrollControls pages={5} damping={0.12}>
                        <Overlay isControlling={isControlling} setIsControlling={setIsControlling} isZooming={isZooming} setIsZooming={setIsZooming} isShowStats={isShowStats} setIsShowStats={setIsShowStats} />
                        <MyBG />
                        <Sky sunPosition={[100, 20, 100]} distance={99999999} />
                        {/* <Environment preset='dawn' /> */}
                    </ScrollControls>
                </Suspense>
            </Canvas>

        </>
    );
}
