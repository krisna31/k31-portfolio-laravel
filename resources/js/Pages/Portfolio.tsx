// import { initFlowbite } from "flowbite";
import { Button, Card, List } from 'flowbite-react';
import { Head } from '@inertiajs/react';
import { Avatar, Dropdown, Navbar } from 'flowbite-react';
import { useState } from 'react';

export default function Portfolio() {
    const [activeLink, setActiveLink] = useState('Home');
    // useEffect(() => {
    //     initFlowbite();
    // }, [])

    // const getRandomColorClass = () => {
    //     const colors = [
    //         'slate', 'gray', 'zinc', 'neutral', 'stone',
    //         'red', 'orange', 'amber', 'yellow', 'lime',
    //         'green', 'emerald', 'teal', 'cyan', 'sky',
    //         'blue', 'indigo', 'violet', 'purple', 'fuchsia',
    //         'pink', 'rose'
    //     ];

    //     const randomColor = colors[Math.floor(Math.random() * colors.length)];
    //     const randomShade = Math.floor(Math.random() * 950) + 50;
    //     return `${randomColor}-${randomShade}`;
    // };

    // const gradientClass = getRandomColorClass();

    return (
        <section className={`flex items-start text-white bg-[url('assets/pictures/bg.jpg')] bg-cover bg-center h-full flex-col`}>
            <div className="w-full h-full flex flex-col justify-start items-start backdrop-blur-md md:py-10">

                <Head title="Jelvin Krisna Putra">
                    <link rel="icon" type="image/svg+xml+ico" href="/assets/pictures/logo.png" />
                </Head>
                <section className='mx-auto container bg-red-600 rounded-md bg-clip-padding backdrop-filter backdrop-blur-3xl bg-opacity-20 border border-gray-100'>
                    <div className="overflow-x-auto container mx-auto">
                        <Navbar fluid rounded>
                            <Navbar.Brand href="#">
                                <img src="assets/pictures/logo.png" className="mr-3 h-6 sm:h-9" alt="K31 Logo" />
                                {/* <span className="self-center whitespace-nowrap text-xl font-semibold dark:text-white">K31</span> */}
                            </Navbar.Brand>
                            <div className="flex md:order-2">
                                <Dropdown
                                    arrowIcon={false}
                                    inline
                                    label={
                                        <Avatar alt="User settings" img="assets/pictures/jelvinkrisnaputra.jpg" rounded />
                                    }
                                >
                                    <Dropdown.Header>
                                        <span className="block text-sm">Jelvin Krisna Putra</span>
                                        <span className="block truncate text-sm font-medium">krisnaaaputraaa@gmail.com</span>
                                    </Dropdown.Header>
                                </Dropdown>
                                <Navbar.Toggle />
                            </div>
                            <Navbar.Collapse>
                                <Navbar.Link href="#" active={activeLink === 'Home'} onClick={() => setActiveLink('Home')}>
                                    Home
                                </Navbar.Link>
                                <Navbar.Link href="#summary" active={activeLink === 'Summary'} onClick={() => setActiveLink('Summary')}>
                                    Summary
                                </Navbar.Link>
                                <Navbar.Link href="#experience" active={activeLink === 'Experience'} onClick={() => setActiveLink('Experience')}>
                                    Experience
                                </Navbar.Link>
                                <Navbar.Link href="#education" active={activeLink === 'Education'} onClick={() => setActiveLink('Education')}>
                                    Education
                                </Navbar.Link>
                                <Navbar.Link href="#organization" active={activeLink === 'Organization'} onClick={() => setActiveLink('Organization')}>
                                    Organization
                                </Navbar.Link>
                                <Navbar.Link href="#project" active={activeLink === 'Projects'} onClick={() => setActiveLink('Projects')}>
                                    Projects
                                </Navbar.Link>
                                <Navbar.Link href="#certification" active={activeLink === 'Certifications'} onClick={() => setActiveLink('Certifications')}>
                                    Certifications
                                </Navbar.Link>
                                <Navbar.Link href="/app/login" active={activeLink === 'login'} onClick={() => setActiveLink('login')} className='font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-black to-pink-600'>
                                    More Apps
                                </Navbar.Link>
                            </Navbar.Collapse>
                        </Navbar>
                    </div>
                    <section id='contact' className='mx-5'>
                        <h1 className='md:text-3xl text-xl mt-3'>Jelvin Krisna Putra</h1>
                        <p className='text-sm mb-3 text-gray-200'>Palembang | <a className='text-blue-500 underline underline-offset-1' href="tel:+628982509595">+62 898-250-9595</a> | <a href="mailto:krisnaaaputraaa@gmail.com" className='text-blue-500 underline underline-offset-1'>@gmail</a> | <a href="https://www.linkedin.com/in/jelvin-krisna-putra/" className='text-blue-500 underline underline-offset-1'>@Linkedin</a></p>
                    </section>
                    <section id='summary' className='mx-5 scroll-mt-3'>
                        <h1 className='md:text-3xl text-xl my-3 border-b-blue-700  border-b-4 border-double'>Summary</h1>
                        <p className='text-md md:text-xl my-3'>Passionate web developer🕸️ and cloud engineer ☁️ from Indonesia, currently in the sixth semester of the Informatics program at Multi Data Palembang University. I have successfully completed the Cloud Computing Learning Path at Bangkit Academy, with 2 years experience in informatics organizations, 6 months as a lecturer assistant, and 6 months of mentoring. I am enthusiastic about web development, backend, and cloud engineering.</p>
                    </section>
                    <section id='experience' className='mx-5 scroll-mt-3'>
                        <h1 className='md:text-3xl text-xl my-3 border-b-blue-700 border-b-4 border-double'>Experience</h1>
                        <h1 className="md:text-xl text-md font-bold border-b-blue-700 border-b">DBS Foundation Coding Camp - Online</h1>
                        <p className="text-md mb-3">
                            <span className="font-bold">Backend Mentor (June 2023 - Nov 2023)</span>
                            <List className='text-white'>
                                <List.Item>Guided intermediate and expert developers to successful className completion.</List.Item>
                                <List.Item>Ensured a plagiarism-free learning environment.</List.Item>
                                <List.Item>Led regular online study groups (30-60 mins) via WA Group and Conference Call.</List.Item>
                            </List>
                        </p>
                        <h2 className="md:text-xl text-md font-bold border-b-blue-700 border-b">Multi Data Palembang University - Palembang, Indonesia</h2>
                        <p className="text-md mb-3">
                            <span className="font-bold">Assistant Lecturer (Jan 2023 - June 2023)</span>
                            <List className='text-white'>
                                <List.Item>Assisted in teaching web programming concepts, covering both Node.js and Laravel.</List.Item>
                                <List.Item>Facilitated effective communication for student understanding.</List.Item>
                                <List.Item>Contributed to a constructive learning environment.</List.Item>
                            </List>
                        </p>
                    </section>
                    <section id='education' className='mx-5 scroll-mt-3'>
                        <h1 className='md:text-3xl text-xl my-3 border-b-blue-700 border-b-4 border-double'>Education</h1>
                        <h1 className="md:text-xl text-md font-bold border-b-blue-700 border-b">BANGKIT ACADEMY (August 2023 - January 2024)</h1>
                        <p className="text-md mb-3">
                            <span className="font-bold">Cloud Computing Cohorts</span>
                            <List className='text-white'>
                                <List.Item>Learning Everything About Cloud.</List.Item>
                            </List>
                        </p>
                        <h2 className="md:text-xl text-md font-bold border-b-blue-700 border-b">UNIVERSITAS MULTI DATA PALEMBANG (2021 - 2025)</h2>
                        <p className="text-md mb-3">
                            <span className="font-bold">Pursuing Bachelor of Computer Science - GPA 3.95</span>
                            <List className='text-white'>
                                <List.Item>Formal Education Computer Science Degree.</List.Item>
                            </List>
                        </p>
                    </section>
                    <section id='organization' className='mx-5 scroll-mt-3'>
                        <h1 className='md:text-3xl text-xl my-3 border-b-blue-700 border-b-4 border-double'>Organizations</h1>
                        <h1 className="md:text-xl text-md font-bold">Computer Science Student Association - Palembang, Indonesia</h1>
                        <p className="text-md mb-3">
                            <span className="font-bold">Member (July 2022 - April 2023)</span>
                            <span className="font-bold">Head of Education and Technology Department (June 2023 - present)</span>
                            {/* <List className='text-white'>
                                <List.Item>Learning Everything About Cloud.</List.Item>
                            </List> */}
                        </p>
                        <h2 className="md:text-xl text-md font-bold">Student Programming Activities Unit - Palembang, Indonesia</h2>
                        <p className="text-md mb-3">
                            <span className="font-bold">Vice Chair of the Web Department (June 2022 - present)</span>
                            {/* <List className='text-white'>
                                <List.Item>Formal Education Computer Science Degree.</List.Item>
                            </List> */}
                        </p>
                    </section>
                    <section id='project' className='mx-5 mb-8 scroll-mt-3'>
                        <h1 className='md:text-3xl text-xl my-3 border-b-blue-700 border-b-4 border-double'>Projects</h1>
                        <div className="flex justify-around items-center flex-wrap gap-5">
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/interviewku.png" alt="InterviewKu" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    InterviewKu
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    InterviewKu is an Android application that provides interview simulation feature. This app is built as our Capstone Project from team CH2-PS195 at Bangkit Academy 2023 Batch 2, with a theme centered around Job, Talent, and Employment.
                                </p>
                                <Button href='https://github.com/krisna31/interviewku'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/laporkelah.png" alt="Laporkelah API & Admin Panel" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Laporkelah API & Admin Panel
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    Laporkelah-laravel is a Laravel-based repository designed for API development and backend functionality, including an admin panel powered by Laravel Breeze.
                                </p>
                                <Button href='https://github.com/krisna31/laporkelah-laravel'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/k31-watch.jpeg" alt="Flutter K31 Watch App use  themoviedb API" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Flutter K31 Watch App use themoviedb API
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    This project involves creating a Flutter application that displays movies and TV series using domain-driven design combined with Bloc state management, utilizing TheMovieDB API. Feel free to ask for clarifications.
                                </p>
                                <Button href='https://github.com/krisna31/k31_watch_flutter'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/db-library.png" alt="Library Database Design" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Library Database Design
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    This project involves creating a library database using SQL Developer Data Modeler. Check the provided model file and explore logical and physical designs. Open SQL Developer Data Modeler to view entities, relationships, and attributes. Feel free to ask for clarifications.
                                </p>
                                <Button href='https://github.com/krisna31/library-database-design'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/jaya-dropout-dashboard.png" alt="Jaya Jaya Institut - Machine Learning" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Jaya Jaya Institut - Machine Learning
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    Jaya Jaya Institut, didirikan pada tahun 2000, mengalami tantangan mengelola tingginya angka dropout siswa. Institut ini berkeinginan untuk segera mendeteksi potensi siswa yang akan melakukan dropout guna memberikan bimbingan khusus. Sebagai calon data scientist, tugasnya adalah mengembangkan sistem machine learning untuk mendeteksi potensi dropout siswa dan membuat business dashboard untuk memantau perkembangan siswa.
                                </p>
                                <Button href='https://github.com/krisna31/submission-belajar-penerapan-data-science/tree/main/jaya-jaya-institut-dropout'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/jaya-maju-dashboard.png" alt="Jaya Jaya Maju - Machine Learning" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Jaya Jaya Maju - Machine Learning
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    Perusahaan Jaya Jaya Maju, perusahaan multinasional sejak tahun 2000, menghadapi tantangan dalam mengelola karyawan dengan attrition rate lebih dari 10%. Manajer HR dan data scientist bekerja sama untuk mengidentifikasi faktor-faktor penyebab tingginya attrition rate dan membuat business dashboard untuk pemantauan.
                                </p>
                                <Button href='https://github.com/krisna31/submission-belajar-penerapan-data-science/tree/main/jaya-jaya-maju-atrition'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/open-music.jpeg" alt="Open Music API" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Open Music API
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    OpenMusic, aplikasi pemutar musik terbuka, sedang dikembangkan oleh tim TSC. Aplikasi ini akan menyediakan musik berlisensi gratis dengan fitur-fitur seperti menambahkan lagu, membuat playlist, dan berbagi playlist. Fokus saat ini pada pengembangan API, memungkinkan pengguna untuk menambah, menghapus, dan mengubah data album dan lagu pada tahap versi pertama. Tujuan akhirnya adalah menjadikan OpenMusic sebagai aplikasi nomor satu di dunia.
                                </p>
                                <Button href='https://github.com/krisna31/producer-open-music-api'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/bike-share.png" alt="Bike Share By Day Analysis - Machine Learning" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Bike Share By Day Analysis - Machine Learning
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    Proyek Analisis Data menggunakan Bike Sharing Dataset. Atribut data mencakup indeks rekaman, tanggal, dll. Pertanyaan bisnis yang diajukan melibatkan analisis performa jumlah peminjaman sepeda dalam 12 bulan terakhir dengan mempertimbangkan cuaca, hari kerja, dan hari libur.
                                </p>
                                <Button href='https://github.com/krisna31/bike-share-by-day-analysis'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/forum-api.jpeg" alt="Forum API - Hapi.js" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Forum API - Hapi.js
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    Garuda Game, perusahaan fiktif di industri game online, akan membuat aplikasi forum resmi di platform web dan mobile native. Mereka fokus pada desain matang dengan automation testing dan clean architecture agar terhindar dari bug, dapat beradaptasi dengan perubahan teknologi, dan mudah dikembangkan.
                                </p>
                                <Button href='https://github.com/krisna31/forum-api-garuda-game'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/anime-rec.png" alt="Anime Recommendation - Machine Learning" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Anime Recommendation - Machine Learning
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    Proyek data science ini bertujuan menciptakan model machine learning untuk merekomendasikan anime berdasarkan preferensi pengguna. Dengan sistem rekomendasi yang canggih, produk ini diharapkan meningkatkan kepuasan pengguna, mendukung pendapatan, dan menjaga daya saing di industri hiburan.
                                </p>
                                <Button href='https://github.com/krisna31/anime-recommendation-collaborative-filtering'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/github-repo.png" alt="Proyek Lain Lain" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Proyek Lain Lain
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    Semua Proyek yang sudah dikerjakan ada bisa di cek di github saya.
                                </p>
                                <Button href='https://github.com/krisna31'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                        </div>
                    </section>
                    <section id='certification' className='mx-5 mb-8 scroll-mt-3'>
                        <h1 className='md:text-3xl text-xl my-3 border-b-blue-700 border-b-4 border-double'>Certifications</h1>
                        <div className="flex justify-around items-center flex-wrap gap-5">
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/be-expert.png" alt="Menjadi Backend Developer Expert - Dicoding" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Menjadi Backend Developer Expert - Dicoding
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    Kelas ini ditujukan untuk Back-End Developer yang ingin mengetahui best practice dalam mengembangkan RESTful API menggunakan NodeJS, dengan mengacu pada standar industri yang divalidasi AWS. Di akhir kelas ini, siswa mampu membuat aplikasi back-end berupa RESTful API yang testable, scalable, mudah dan cepat untuk di-deploy, serta memiliki keamanan yang baik sesuai dengan standar kebutuhan Industri.
                                </p>
                                <Button href='https://www.dicoding.com/certificates/1OP858OMQPQK'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/kominfo-db.png" alt="Kominfo Database Design & Programming with SQL" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Kominfo Database Design & Programming with SQL
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    Pelatihan ini bertujuan untuk melibatkan peserta untuk menganalisis skenario bisnis yang kompleks dan membuat model data representasi konseptual dari informasi organisasi. Peserta menerapkan desain database dengan membuat physical database menggunakan SQL. Sintaks SQL dasar dan aturan untuk membangun pernyataan SQL yang valid ditinjau. Akhir dari pelatihan ini yaitu proyek yang menantang peserta untuk merancang, mengimplementasikan, dan menunjukkan solusi database untuk bisnis atau organisasi.
                                </p>
                                <Button href='https://www.linkedin.com/in/jelvin-krisna-putra/details/certifications/1635545831843/single-media-viewer/?_l=en_US'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/it-support.png" alt="Google IT Support" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Google IT Support
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    Mereka yang mendapatkan Sertifikat IT Support Profesional Google telah menyelesaikan lima materi yang dikembangkan oleh Google, yang mencakup penilaian berbasis praktik langsung dan dirancang untuk mempersiapkan mereka dalam berbagai posisi pemula di bidang IT Support. Mereka memiliki kompetensi dalam keterampilan dasar, termasuk pemecahan masalah dan layanan pelanggan, jaringan, sistem operasi, administrasi sistem, dan keamanan.
                                </p>
                                <Button href='https://www.coursera.org/account/accomplishments/specialization/certificate/C5VBS44LR4ZK'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/Coursera-pm.png" alt="Google Project Management: Specialization" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Google Project Management: Specialization
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    Those who earn the Google Project Management Certificate have completed six courses, developed by Google, that include hands-on, practice-based assessments and are designed to prepare them for introductory-level roles in Project Management. They are competent in initiating, planning and running both traditional and agile projects.
                                </p>
                                <Button href='https://www.coursera.org/account/accomplishments/specialization/certificate/C5VBS44LR4ZK'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                            <Card
                                className="max-w-sm"
                                renderImage={() => <img className='rounded-lg' width={400} height={400} src="/assets/pictures/linkedin-sertif.jpeg" alt="Sertifikat Saya Lainnya" />}
                            >
                                <h5 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    Sertifikat Saya Lainnya
                                </h5>
                                <p className="font-normal text-gray-700 dark:text-gray-400 line-clamp-3 hover:line-clamp-none md:line-clamp-6 xl:line-clamp-none">
                                    Sertifikat Saya Lainnya bisa lihat di linkedin saya
                                </p>
                                <Button href='https://www.linkedin.com/in/jelvin-krisna-putra/details/certifications/'>
                                    See More
                                    <svg className="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            fillRule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clipRule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </Card>
                        </div>
                    </section>
                </section>
            </div>
            <footer className='text-center p-8 flex justify-center items-center w-full'>
                <p className='text-center'>@{new Date().getFullYear()} Created by <a href="https://github.com/krisna31" className='underline text-blue-400'>@krisna31</a></p>
            </footer>

        </section>
    )
}
