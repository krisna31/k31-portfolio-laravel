import { Scroll, useScroll } from "@react-three/drei";
import { useFrame } from "@react-three/fiber";
import { useState } from "react";

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

                <nav className="fixed top-0 right-0 backdrop-blur-sm rounded m-5 gap-3 flex flex-col">
                    <label className="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" className="sr-only peer" onChange={_ => setIsShowStats(prev => !prev)} checked={isShowStats} />
                        <div className="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                        <span className="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Stats</span>
                    </label>
                    <label className="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" className="sr-only peer" onChange={_ => setIsControlling((prev: any) => {
                            prev && setIsZooming(false);
                            return !prev;
                        })} checked={isControlling} />
                        <div className="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-teal-300 dark:peer-focus:ring-teal-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-teal-600"></div>
                        <span className="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Control</span>
                    </label>
                    <label className="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" className="sr-only peer" onChange={_ => setIsZooming((prev: any) => {
                            !prev && setIsControlling(true);
                            return !prev;
                        })} checked={isZooming} />
                        <div className="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                        <span className="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Zoom</span>
                    </label>
                </nav>

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
                        <div className="flex flex-row justify-between">
                            <a href="https://www.facebook.com/profile.php?id=100006248929202" title="Link Facebook Krisna" className="text-gray-500 hover:text-gray-900 dark:hover:text-white" target="_blank" rel="noopener noreferrer">
                                <svg className="w-5 h-4 md:w-7 md:h-7 lg:w-9 lg:h-9 text-blue-600" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fillRule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clipRule="evenodd"></path>
                                </svg>
                            </a>

                            <a href="https://github.com/krisna31" title="Link Github Krisna" className="text-gray-500 hover:text-gray-900 dark:hover:text-white" target="_blank" rel="noopener noreferrer">
                                <svg className="w-5 h-4 md:w-7 md:h-7 lg:w-9 lg:h-9 text-black" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fillRule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clipRule="evenodd"></path>
                                </svg>
                            </a>

                            <a href="https://www.instagram.com/krisna_putra31/" title="Link Instagram Krisna" className="text-gray-500 hover:text-gray-900 dark:hover:text-white" target="_blank" rel="noopener noreferrer">
                                <svg className="w-5 h-4 md:w-7 md:h-7 lg:w-9 lg:h-9 text-pink-600" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fillRule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clipRule="evenodd"></path>
                                </svg>
                            </a>

                            <a href="https://www.linkedin.com/in/jelvin-krisna-putra-0b8605218/" title="Link Linkedin Krisna" className="text-gray-500 hover:text-gray-900 dark:hover:text-white" target="_blank" rel="noopener noreferrer">
                                <svg className="w-5 h-4 md:w-7 md:h-7 lg:w-9 lg:h-9 text-blue-500 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path>
                                </svg>
                            </a>

                            <a href="https://wa.me/628982509595" title="Link Whatsapp Krisna" className="text-gray-500 hover:text-gray-900 dark:hover:text-white" target="_blank" rel="noopener noreferrer">
                                <svg className="w-5 h-4 md:w-7 md:h-7 lg:w-9 lg:h-9 text-green-400 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path>
                                </svg>
                            </a>
                        </div>
                    </blockquote>
                </Section>
            </div>
        </Scroll>
    );
};
