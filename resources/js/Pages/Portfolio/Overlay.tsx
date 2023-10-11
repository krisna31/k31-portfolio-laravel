import { Scroll, useScroll } from "@react-three/drei";
import { useFrame } from "@react-three/fiber";
import { useState } from "react";
import DefaultContactLinks from "./DefaultContactLinks";

const Section = (props: any) => {
    return (
        <section
            className={`h-screen flex flex-col justify-center p-10 ${props.right ? "items-end" : "items-start"} text-white`}
            style={{
                opacity: props.opacity,
            }}
        >
            <div className={`w-full md:w-1/2 flex items-center justify-center`}>
                <div className="max-w-sm w-full">
                    <div className={`h-full w-full bg-blue-700 bg-clip-padding backdrop-filter backdrop-blur-sm bg-opacity-10 border border-gray-100 rounded-lg px-8 py-12 ${props.class}`}>
                        {props.children}
                    </div>
                </div>
            </div>
        </section>
    );
};

type props = {
    isControlling: boolean,
    setIsControlling: React.Dispatch<React.SetStateAction<boolean>>,
    isZooming: boolean,
    setIsZooming: React.Dispatch<React.SetStateAction<boolean>>
    isShowStats: boolean,
    setIsShowStats: React.Dispatch<React.SetStateAction<boolean>>
}

export const Overlay = ({ isControlling, setIsControlling, isZooming, setIsZooming, isShowStats, setIsShowStats }: props) => {
    const scroll = useScroll();
    const [opacityFirstSection, setOpacityFirstSection] = useState(1);
    const [opacitySecondSection, setOpacitySecondSection] = useState(1);
    const [opacityThirdSection, setOpacityThirdSection] = useState(1);
    const [opacityFourthSection, setOpacityFourthSection] = useState(1);
    const [opacityLastSection, setOpacityLastSection] = useState(1);

    const FLOOR = 5

    useFrame(() => {
        setOpacityFirstSection(1 - scroll.range(0, 1 / FLOOR));
        setOpacitySecondSection(scroll.curve(0.8 / FLOOR, 1 / FLOOR));
        setOpacityThirdSection(scroll.range(1.4 / FLOOR, 1 / FLOOR));
        setOpacityFourthSection(scroll.curve(3.5 / FLOOR, 1 / FLOOR));
        setOpacityLastSection(scroll.range(4 / FLOOR, 1 / FLOOR));
    });

    return (
        <Scroll html>
            <div className="w-screen">

                <Section opacity={opacityFirstSection}>
                    <h1 className="font-semibold font-serif text-2xl">
                        Hi, I'm Jelvin Krisna Putra
                    </h1>
                    <p className="mt-3 text-yellow-400">Programmer | College Student</p>
                    <p className="animate-bounce  mt-6">↓ Scroll Down</p>
                </Section>
                <Section right opacity={opacitySecondSection}>
                    <h1 className="font-semibold font-serif text-2xl mb-3">
                        📜 Biography 📜
                    </h1>
                    <p className="text-yellow-400">
                        I am Jelvin Krisna Putra, born in 2003 in Palembang. My fascination with coding and technology ignited at a young age, evolving into a lifelong passion.

                        Here, you'll find a selection of projects crafted using my primary language, Javascript. Beyond the basics of HTML, CSS, and JavaScript, I've ventured into React, SQL, and more.</p>
                    <p className="animate-bounce  mt-6">↓ Scroll Down</p>
                </Section>
                <Section opacity={opacityThirdSection}>
                    <h1 className="font-semibold font-serif text-2xl mb-3">
                        Skillset 📚
                    </h1>
                    <ul className="leading-9 text-yellow-300">
                        <li>Laravel</li>
                        <li>HapiJS</li>
                        <li>NextJS</li>
                        <li>ReactJS</li>
                        <li>Tailwind</li>
                    </ul>
                    <p className="animate-bounce  mt-6">↓ Scroll Down</p>
                </Section>
                <Section right opacity={opacityFourthSection}>
                    <blockquote className="p-6 text-base font-bold lg:text-xl">
                        <p>
                            "Programming isn't about what you know; it's about what you can figure out.”
                            <br />
                            <br />
                            -Chris Pine
                        </p>
                    </blockquote>
                </Section>
                <Section opacity={opacityLastSection}>
                    <blockquote className="p-6 text-base font-bold">
                        <h2 className="text-2xl mb-3 lg:text-3xl">Social Media</h2>
                        <DefaultContactLinks />
                    </blockquote>
                </Section>
            </div>
        </Scroll>
    );
};
