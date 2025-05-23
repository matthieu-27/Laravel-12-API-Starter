import Image from 'next/image';

export default function FanSpinner() {
  return (
    <div className="h-screen w-screen flex justify-center items-center -mt-6 bg-white z-40">
      <Image src={'/fan.gif'} alt={'fan'} width={402} height={319} className="z-50" />
    </div>
  );
}
