import { Link, Head } from '@inertiajs/react';
import { Box, Environment, OrbitControls, ScrollControls, Sky } from "@react-three/drei";
import { PageProps } from '@/types';
import { Canvas } from '@react-three/fiber';
import { Overlay } from './Portfolio/Overlay';
import { BG } from '@/Components/BG';
import { Suspense, useEffect, useState } from 'react';
import Loader from '@/Components/Loader';

export default function Welcome({ auth, laravelVersion, phpVersion }: PageProps<{ laravelVersion: string, phpVersion: string }>) {
    const [isControlling, setIsControlling] = useState<boolean>(true);
    const [isZooming, setIsZooming] = useState<boolean>(false);

    return (
        <>
            <Head title="Welcome" />
            <Canvas shadows camera={{ position: [0, 0, 15] }}>
                <Suspense fallback={<Loader />}>
                    <ambientLight intensity={0.8} />
                    {isControlling && (
                        <OrbitControls enableZoom={isZooming} autoRotate />
                    )}
                    <ScrollControls pages={5} damping={0.12}>
                        <Overlay isControlling={isControlling} setIsControlling={setIsControlling} isZooming={isZooming} setIsZooming={setIsZooming} />
                        <BG />
                        {/* <Sky sunPosition={[100, 20, 100]} distance={99999999} />
                        <Environment preset='dawn' /> */}
                    </ScrollControls>
                </Suspense>
            </Canvas>

        </>
    );
}
