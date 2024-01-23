// import { initFlowbite } from "flowbite";
import { Head } from '@inertiajs/react';
import { Avatar, Dropdown, Navbar } from 'flowbite-react';

export default function Portfolio() {

    // useEffect(() => {
    //     initFlowbite();
    // }, [])

    return (
        <>
            <Head title="Jelvin Krisna Putra">
                <link rel="icon" type="image/svg+xml+ico" href="/assets/pictures/logo.png" />
            </Head>
            <section className='bg-black mx-20 my-8'>
                <div className="overflow-x-auto">
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
                                    <Avatar alt="User settings" img="https://flowbite.com/docs/images/people/profile-picture-5.jpg" rounded />
                                }
                            >
                                <Dropdown.Header>
                                    <span className="block text-sm">Bonnie Green</span>
                                    <span className="block truncate text-sm font-medium">name@flowbite.com</span>
                                </Dropdown.Header>
                                <Dropdown.Item>Dashboard</Dropdown.Item>
                                <Dropdown.Item>Settings</Dropdown.Item>
                                <Dropdown.Item>Earnings</Dropdown.Item>
                                <Dropdown.Divider />
                                <Dropdown.Item>Sign out</Dropdown.Item>
                            </Dropdown>
                            <Navbar.Toggle />
                        </div>
                        <Navbar.Collapse>
                            <Navbar.Link href="#" active>
                                Home
                            </Navbar.Link>
                            <Navbar.Link href="#">About</Navbar.Link>
                            <Navbar.Link href="#">Services</Navbar.Link>
                            <Navbar.Link href="#">Pricing</Navbar.Link>
                            <Navbar.Link href="#">Contact</Navbar.Link>
                        </Navbar.Collapse>
                    </Navbar>
                </div>
                <h1>Hello WOrld</h1>
            </section>
        </>
    )
}
