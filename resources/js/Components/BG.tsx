/*
Auto-generated by: https://github.com/pmndrs/gltfjsx
Command: npx gltfjsx@6.2.13 public/assets/model/model.glb -t
*/

import * as THREE from 'three'
import React, { useRef, useLayoutEffect } from 'react'
import { useGLTF, useScroll } from '@react-three/drei'
import { useFrame } from "@react-three/fiber";
import gsap from "gsap";
import { GLTF } from 'three-stdlib'

type GLTFResult = GLTF & {
    nodes: {
        Starry_night_sky_HDRi_background_photosphere: THREE.Mesh
        Earth: THREE.Mesh
    }
    materials: {
        ['material.001']: THREE.MeshStandardMaterial
        ['Scene_-_Root']: THREE.MeshStandardMaterial
    }
}

type ContextType = Record<string, React.ForwardRefExoticComponent<JSX.IntrinsicElements['mesh']>>

export function BG(props: JSX.IntrinsicElements['group']) {
    const { nodes, materials } = useGLTF('/assets/model/model.glb') as GLTFResult

    const ref: any = useRef();
    const tl: React.MutableRefObject<gsap.core.Timeline> = useRef(gsap.timeline());
    const bgRef: any = useRef();

    const scroll = useScroll();

    useFrame((state, delta) => {
        tl.current.seek(scroll.offset * tl.current.duration());
    });

    useLayoutEffect(() => {
        tl.current = gsap.timeline();

        // VERTICAL ANIMATION
        tl.current.to(
            ref.current.position,
            {
                duration: 1.5,
                y: -100,
            },
            0
        );

        // bg rotation
        tl.current.to(
            bgRef.current.rotation,
            { duration: 1, x: 0, y: Math.PI / 3, z: 0 },
            0
        )

        // Office Rotation
        // tl.current.to(
        //     ref.current.rotation,
        //     { duration: 1, x: 0, y: Math.PI / 6, z: 0 },
        //     0
        // );
        // tl.current.to(
        //     ref.current.rotation,
        //     { duration: 1, x: 0, y: -Math.PI / 6, z: 0 },
        //     1
        // );

        // // Office movement
        // tl.current.to(
        //     ref.current.position,
        //     {
        //         duration: 1,
        //         x: -1,
        //         z: 2,
        //     },
        //     0
        // );
        // tl.current.to(
        //     ref.current.position,
        //     {
        //         duration: 1,
        //         x: 1,
        //         z: 2,
        //     },
        //     1
        // );

        // LIBRARY FLOOR
        // tl.current.from(
        //     libraryRef.current.position,
        //     {
        //         duration: 0.5,
        //         x: -2,
        //     },
        //     0.5
        // );
        // tl.current.from(
        //     libraryRef.current.rotation,
        //     {
        //         duration: 0.5,
        //         y: -Math.PI / 2,
        //     },
        //     0
        // );

        // // ATTIC
        // tl.current.from(
        //     atticRef.current.position,
        //     {
        //         duration: 1.5,
        //         y: 2,
        //     },
        //     0
        // );

        // tl.current.from(
        //     atticRef.current.rotation,
        //     {
        //         duration: 0.5,
        //         y: Math.PI / 2,
        //     },
        //     1
        // );

        // tl.current.from(
        //     atticRef.current.position,
        //     {
        //         duration: 0.5,

        //         z: -2,
        //     },
        //     1.5
        // );
    }, []);


    return (
        <group {...props} dispose={null} ref={ref}>
            <mesh ref={bgRef} geometry={nodes.Starry_night_sky_HDRi_background_photosphere.geometry} material={materials['material.001']} position={[-0.538, 2.372, -0.031]} scale={177.063} />
            <mesh geometry={nodes.Earth.geometry} material={materials['Scene_-_Root']} position={[1.019, 5.417, -2.25]} rotation={[0.342, 1.372, -2.96]} scale={2.76} />
        </group>
    )
}

useGLTF.preload('/assets/model/model.glb')
