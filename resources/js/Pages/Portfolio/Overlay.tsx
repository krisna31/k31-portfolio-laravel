import { Scroll, useScroll } from "@react-three/drei";
import { useFrame } from "@react-three/fiber";
import { useState } from "react";
import DefaultContactLinks from "./DefaultContactLinks";
import { PageProps } from "@/types";
import { PortfolioTypes } from "../Portfolio";

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

export const Overlay = ({ portfolio }: { portfolio: PortfolioTypes }) => {
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
                        {portfolio.title}
                    </h1>
                    <div className="mt-3 text-yellow-400"
                        dangerouslySetInnerHTML={{ __html: portfolio.subtitle }}
                    />
                    <p className="animate-bounce  mt-6">↓ {portfolio.scroll_text}</p>
                </Section>
                <Section right opacity={opacitySecondSection}>
                    <h1 className="font-semibold font-serif text-2xl mb-3">
                        {portfolio.bio_title}
                    </h1>
                    <div className="text-yellow-400"
                        dangerouslySetInnerHTML={{ __html: portfolio.bio_subtitle }}
                    />
                    <p className="animate-bounce  mt-6">↓ {portfolio.scroll_text}</p>
                </Section>
                <Section opacity={opacityThirdSection}>
                    <h1 className="font-semibold font-serif text-2xl mb-3">
                        {portfolio.skill_title}
                    </h1>
                    <ul className="leading-9 text-yellow-300">
                        {
                            portfolio.skill_sets.map((skill, index) => {
                                return <li key={skill.id}>{skill.title}</li>
                            })
                        }
                    </ul>
                    <p className="animate-bounce  mt-6">↓ {portfolio.scroll_text}</p>
                </Section>
                <Section right opacity={opacityFourthSection}>
                    <blockquote className="p-6 text-base font-bold lg:text-xl">
                        <div
                            dangerouslySetInnerHTML={{ __html: portfolio.quote }}
                        />
                        <p>
                            <br />
                            <br />
                            -{portfolio.quote_author}
                        </p>
                    </blockquote>
                </Section>
                <Section opacity={opacityLastSection}>
                    <blockquote className="p-6 text-base font-bold">
                        <h2 className="text-2xl mb-3 lg:text-3xl">{portfolio.contact_links_title}</h2>
                        {
                            portfolio.is_using_default_contact_links ?
                                (
                                    <DefaultContactLinks />
                                ) :
                                (
                                    <div className="flex flex-row justify-between">
                                        {
                                            portfolio.contact_me_links.map((contact_link, index) => {
                                                return (
                                                    <a href={contact_link.link} title={contact_link.title} className="text-gray-500 hover:text-gray-900 dark:hover:text-white" target="_blank" rel="noopener noreferrer" key={contact_link.id}>
                                                        <img src={contact_link.icon} alt={contact_link.title} />
                                                    </a>
                                                )
                                            })
                                        }
                                    </div>
                                )
                        }
                    </blockquote>
                </Section>
            </div>
        </Scroll>
    );
};
