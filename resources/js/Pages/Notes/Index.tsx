import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { PageProps } from '@/types';
import ShowFlash from '@/Components/ShowFlash';
import { FormEventHandler } from 'react';

export default function Index({ auth, notes, flash }: PageProps) {
    const { data, setData, delete: deleteMethod, processing, errors, reset } = useForm({
        title: '',
        body: '',
    });

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Let's write some note for today</h2>}
        >
            <Head title="Notes" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <ShowFlash errors={flash.errors} success={flash.success} />
                    <div className="flex flex-col">
                        <Link href={route('notes.create')} type="button" className="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 w-full">Create</Link>
                    </div>
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg grid grid-cols-3 gap-4 p-2 my-3">
                        {notes.length > 0 &&
                            notes.map((note) => {
                                return (
                                    <>
                                        <Link key={note.id} href={route('notes.show', note.id)} className="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 flex-1">
                                            {/* <img className="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" src="/docs/images/blog/image-4.jpg" alt="" /> */}
                                            <div className="flex flex-col justify-between p-4 leading-normal">
                                                <h5 className="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{note.title}</h5>
                                                <p className="mb-3 font-normal text-gray-700 dark:text-gray-400">{note.body}
                                                </p>
                                                <div className="grid grid-cols-2 gap-2">
                                                    <Link href={route('notes.edit', note.id)} className="items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-400 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                                        Edit
                                                    </Link>
                                                    <button onClick={e => {
                                                        e.preventDefault()
                                                        if (confirm(`Are you sure delete ${note.title}?`)) {
                                                            deleteMethod(route('notes.destroy', note.id))
                                                        }
                                                    }} className="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-400 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </Link>
                                    </>
                                );
                            })
                        }
                    </div>
                </div>
            </div>

        </AuthenticatedLayout>
    );
}
