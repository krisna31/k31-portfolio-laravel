import { Link, Head } from '@inertiajs/react';
import { Box, OrbitControls, ScrollControls } from "@react-three/drei";
import { PageProps } from '@/types';
import { Canvas } from '@react-three/fiber';
import { Overlay } from './Portfolio/Overlay';

export default function Welcome({ auth, laravelVersion, phpVersion }: PageProps<{ laravelVersion: string, phpVersion: string }>) {
    return (
        <>
            <Head title="Welcome" />
            <Canvas>
                <>
                    <ambientLight intensity={1} />
                    <OrbitControls enableZoom={false} />
                    <ScrollControls pages={3} damping={0.25}>
                        <Overlay />
                        {/* <Office /> */}
                    </ScrollControls>
                </>
            </Canvas>

        </>
    );
}
