/* eslint-disable @typescript-eslint/no-explicit-any */
/*
Auto-generated by: https://github.com/pmndrs/gltfjsx
Command: npx gltfjsx@6.2.13 bg.gltf -t
*/

import * as THREE from 'three'
import React, { useRef, useLayoutEffect } from 'react'
import { useGLTF, useScroll } from '@react-three/drei'
import { GLTF } from 'three-stdlib'
import { useFrame } from "@react-three/fiber";
import gsap from "gsap";

type GLTFResult = GLTF & {
  nodes: {
    Object_4: THREE.Mesh
    Object_2: THREE.Mesh
    Sphere_Material_0: THREE.Mesh
    Sphere_Material002_0001: THREE.Mesh
    Sphere_Material002_0005: THREE.Mesh
    Sphere_Material002_0003: THREE.Mesh
    Object_6: THREE.Mesh
    Object_4001: THREE.Mesh
    Sphere_Material002_0002: THREE.Mesh
    Sphere_Material002_0: THREE.Mesh
    k31: THREE.Mesh
  }
  materials: {
    ['.003']: THREE.MeshStandardMaterial
    material: THREE.MeshStandardMaterial
    ['Material.001']: THREE.MeshStandardMaterial
    ['Material.003']: THREE.MeshStandardMaterial
    ['Material.007']: THREE.MeshStandardMaterial
    ['Material.005']: THREE.MeshStandardMaterial
    star: THREE.MeshStandardMaterial
    ['Material.004']: THREE.MeshStandardMaterial
    ['Material.006']: THREE.MeshStandardMaterial
    ['profile (1)']: THREE.MeshStandardMaterial
  }
}

// type ContextType = Record<string, React.ForwardRefExoticComponent<JSX.IntrinsicElements['mesh']>>

export function Bg(props: JSX.IntrinsicElements['group']) {
  const { nodes, materials } = useGLTF('/assets/model/bg.gltf') as GLTFResult

  const parentRef: any = useRef();
  const tl: React.MutableRefObject<gsap.core.Timeline> = useRef(gsap.timeline());
  const bgRef: any = useRef();
  const k31: any = useRef();
  const planetRef: any = useRef();

  const scroll = useScroll();

  useFrame(() => {
    tl.current.seek(scroll.offset * tl.current.duration());

    k31.current.rotation.y += 0.001;
    k31.current.rotation.x += 0.001;

    planetRef.current.rotation.x += 0.001;
    planetRef.current.rotation.y += 0.001;
  });

  useLayoutEffect(() => {
    tl.current = gsap.timeline();

    // VERTICAL ANIMATION
    tl.current.to(
      parentRef.current.position,
      {
        duration: 1.5,
        y: -35,
      },
      0
    );

    // bg rotation
    tl.current.to(
      bgRef.current.rotation,
      { duration: 1, x: 0, y: Math.PI / 3, z: 0 },
      0
    )
  }, []);

  return (
    <group {...props} dispose={null} ref={parentRef}>
      <mesh ref={bgRef} geometry={nodes.Object_4.geometry} material={materials['.003']} scale={194.172} />
      <group position={[-1.515, 6.428, 0.787]} rotation={[-Math.PI / 2, 0, 0]} scale={1.078} ref={planetRef} onClick={() => {
        planetRef.current.scale.x += 1;
        planetRef.current.scale.y += 1;
        planetRef.current.scale.z += 1;
      }}>
        <mesh geometry={nodes.Object_2.geometry} material={materials.material} position={[-0.571, -8.532, 2.774]} />
      </group>
      <group position={[-4.009, 23.13, -11.824]} rotation={[-Math.PI / 2, 0, 0]} scale={0.026}>
        <group rotation={[Math.PI / 2, 0, 0]} scale={0.01}>
          <group position={[0, -0.008, 0.008]}>
            <mesh geometry={nodes.Sphere_Material_0.geometry} material={materials['Material.001']} position={[0, -0.008, 0.008]} rotation={[-Math.PI / 2, 0, 0]} scale={101} />
          </group>
        </group>
      </group>
      <group position={[-5.631, 23.905, 0.909]} rotation={[-Math.PI / 2, 0, 0]} scale={0.012}>
        <group scale={100}>
          <mesh geometry={nodes.Sphere_Material002_0001.geometry} material={materials['Material.003']} position={[1.932, 0.014, 7.27]} />
        </group>
      </group>
      <group position={[-2.677, 12.883, -2.386]} rotation={[-Math.PI / 2, 0, 0]} scale={0.009}>
        <group scale={100}>
          <mesh geometry={nodes.Sphere_Material002_0005.geometry} material={materials['Material.007']} position={[-3.49, -5.323, 6.049]} />
        </group>
      </group>
      <group position={[-2.778, 11.741, -0.824]} rotation={[-Math.PI / 2, 0, 0]} scale={0.004}>
        <group scale={100}>
          <mesh geometry={nodes.Sphere_Material002_0003.geometry} material={materials['Material.005']} position={[3.706, -19.153, -14.911]} />
        </group>
      </group>
      <group position={[-9.514, 44.453, 99.432]} rotation={[-Math.PI / 2, 0, 0]} scale={0.385}>
        <group rotation={[Math.PI / 2, 0, 0]}>
          <mesh geometry={nodes.Object_6.geometry} material={materials.star} position={[0, 0, 0.567]} rotation={[Math.PI / 2, 0, 0]} scale={2.506} />
          <mesh geometry={nodes.Object_4001.geometry} material={materials.star} rotation={[Math.PI / 2, 0, 3.135]} scale={2.506} />
        </group>
      </group>
      <group position={[-4.266, 18.147, 1.568]} rotation={[-Math.PI / 2, 0, 0]} scale={0.022}>
        <group scale={100}>
          <mesh geometry={nodes.Sphere_Material002_0002.geometry} material={materials['Material.004']} position={[0.386, -8.748, 7.518]} />
        </group>
      </group>
      <group position={[1.491, 7.238, 4.387]} rotation={[-Math.PI / 2, 0, 0]} scale={0.015}>
        <group rotation={[Math.PI / 2, 0, 0]}>
          <mesh geometry={nodes.Sphere_Material002_0.geometry} material={materials['Material.006']} rotation={[-Math.PI / 2, 0, 0]} scale={100} />
        </group>
      </group>
      <mesh geometry={nodes.k31.geometry} material={materials['profile (1)']} position={[0.503, 0.397, 2.39]} rotation={[1.575, -0.039, 1.686]} scale={2.127} ref={k31} />
    </group>
  )
}

useGLTF.preload('/assets/model/bg.gltf')
