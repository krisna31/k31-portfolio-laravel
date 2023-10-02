import { Html, useProgress } from '@react-three/drei'
import { useEffect, useState } from 'react';

export default function Loader() {
    const { active, progress, errors, item, loaded, total } = useProgress();

    const [percent, setPercent] = useState(0);

    useEffect(() => {
        progress > percent && setPercent(percent + 1);
        percent >= 100 && setTimeout(() => {
            document.querySelector('#app')?.classList.add('bg-black')
        }, 1000);;
    });

    return (
        <Html center={true} className='box-border'>
            <div className="mb-1 text-base font-medium text-white dark:text-white text-center">{percent} % loaded</div>
            <div className="w-80 bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
                <div className="bg-yellow-400 h-2.5 rounded-full w-1/2" style={{ width: `${percent}%` }}></div>
            </div>
        </Html>
    )
}
