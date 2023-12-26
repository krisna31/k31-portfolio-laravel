import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { PageProps } from '@/types';
import { FormEventHandler, useEffect } from 'react';
import InputError from '@/Components/InputError';

export default function Index({ auth, note }: PageProps) {

    const { data, setData, put, processing, errors, reset } = useForm({
        title: note.title,
        body: note.body,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        put(route('notes.update', note.id));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Note</h2>}
        >
            <Head title="Create Note" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <form onSubmit={submit} className="max-w-md mx-auto my-5">
                            <div className="relative z-0 w-full mb-5 group">
                                <input type="text" name="title" id="floating_title" className="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required value={data.title} onChange={e => setData('title', e.target.value)} />
                                <label htmlFor="floating_title" className="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Title Note</label>
                            </div>
                            <InputError message={errors.title} className="mb-3" />

                            <label htmlFor="message" className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Body Note</label>
                            <textarea id="message" rows={4} className="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..." value={data.body} onChange={e => setData('body', e.target.value)}></textarea>

                            <InputError message={errors.body} className="mb-3" />

                            <button type="submit" className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" disabled={processing}>Edit</button>

                        </form>
                    </div>
                </div>
            </div>

        </AuthenticatedLayout>
    );
}
