import { Link, Head } from '@inertiajs/react';
import { Box, OrbitControls, ScrollControls } from "@react-three/drei";
import { PageProps } from '@/types';
import { Canvas } from '@react-three/fiber';
import { Overlay } from './Portfolio/Overlay';
import { BG } from '@/Components/BG';
import { useEffect, useState } from 'react';

export default function Welcome({ auth, laravelVersion, phpVersion }: PageProps<{ laravelVersion: string, phpVersion: string }>) {
    const [isControlling, setIsControlling] = useState<boolean>(true);

    return (
        <>
            <Head title="Welcome" />
            <Canvas shadows camera={{ position: [0, 0, 15] }}>
                <>
                    <ambientLight intensity={0.8} />
                    {isControlling && (
                        <OrbitControls enableZoom={false} autoRotate />
                    )}
                    <ScrollControls pages={5} damping={0.12}>
                        <Overlay isControlling={isControlling} setIsControlling={setIsControlling} />
                        <BG />
                    </ScrollControls>
                </>
            </Canvas>

        </>
    );
}
