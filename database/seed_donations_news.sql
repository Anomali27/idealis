-- =====================================================
-- PIC Seed Data - Event Donations & News
-- =====================================================

-- Event 2: Mangrove Restoration (target 5,000,000) - event_id = 2
INSERT INTO event_donations (event_id, donor_name, donor_class, amount, message) VALUES
(2, 'Jonathan Lee', 'XII-D', 500000, 'Proud to support this amazing event—keep up the great work!'),
(2, 'Michelle Tan', 'XI-C', 400000, 'Hope this contribution helps make the event unforgettable!'),
(2, 'Andi Pratama', 'XII-A', 350000, 'Semangat terus untuk seluruh panitia dan peserta!'),
(2, 'Brian Smith', 'X-C', 250000, 'Happy to be part of something impactful and meaningful.'),
(2, 'Siti Rahmawati', 'XI-A', 200000, 'Semoga acara ini berjalan lancar dan sukses besar!');

-- Event 3: Senior Care Home (target 7,500,000) - event_id = 3
INSERT INTO event_donations (event_id, donor_name, donor_class, amount, message) VALUES
(3, 'Mr. Jonathan Lim', 'Teacher', 2000000, 'Small acts of kindness create big impacts.'),
(3, 'Aisha Khan', 'XI-B', 1200000, 'Spreading love across generations ❤️'),
(3, 'Kevin Lee', 'XII-E', 1000000, 'Happy to support this meaningful cause.'),
(3, 'Maria Gonzalez', 'X-D', 800000, 'For smiles and memories together.'),
(3, 'Daniel Park', 'X-D', 700000, 'Giving back to the community matters.');

-- Event 6: Kunjungan Kasih (target 15,000,000) - event_id = 6
INSERT INTO event_donations (event_id, donor_name, donor_class, amount, message) VALUES
(6, 'Jonathan Lee', 'XII-A', 2000000, 'Hope this brings happiness to the kids!'),
(6, 'Siti Rahmawati', 'Teacher', 1750000, 'Keep spreading kindness and compassion.'),
(6, 'Ethan Wong', 'XI-C', 1500000, 'Small help, big impact.'),
(6, 'Maria Gonzalez', 'X-B', 1250000, 'Wishing all the children a bright future.'),
(6, 'Rizky Saputra', 'XII-D', 1000000, 'Proud to be part of this meaningful event.');

-- Event 9: Flood Relief (target 25,000,000) - event_id = 9
INSERT INTO event_donations (event_id, donor_name, donor_class, amount, message) VALUES
(9, 'Michelle Tan', 'XII-A', 3000000, 'Stay strong, we are with you.'),
(9, 'Ahmad Fauzan', 'Teacher', 2500000, 'Wishing safety and recovery for all families.'),
(9, 'Liam Chen', 'XI-D', 2000000, 'Hope this helps rebuild the community.'),
(9, 'Putri Handayani', 'X-A', 1750000, 'Sending prayers and support.'),
(9, 'Ryan Smith', 'XI-B', 1500000, 'Together we can overcome this.');

-- =====================================================
-- News (4 items)
-- =====================================================
INSERT INTO news (title, image_url, date, description, category) VALUES
(
    'Victory Celebration: National Robotics Championship Award Ceremony',
    '/assets/images/latest/national-robotic-championship.png',
    '2026-03-04',
    'This event was a formal commemorative ceremony to honor the outstanding achievement of our student body at the National Robotics Championship. After weeks of intense competition against the top technical schools in the country, PIC was officially crowned the 1st Place Winner.\n\nThe highlight of the ceremony featured the presentation of the Award of Excellence trophy by the Principal to our lead champion, Julian "Jules" Henderson (XII-E). Julian''s innovative design in autonomous navigation was the key factor in securing the gold. The event served not only to celebrate this specific win but to inspire the next generation of PIC engineers and tech enthusiasts.',
    'Achievement'
),
(
    'UMKM Empowerment Fair: Supporting Local Businesses Through Digital Innovation',
    '/assets/images/latest/umkm-empowerment.png',
    '2026-03-14',
    'The UMKM Empowerment Fair is a bridge between the traditional craftsmanship of Pontianak and modern digital commerce. This event features local micro-enterprises—ranging from Keripik Tempe producers to Kain Songket weavers—showcasing their products while receiving hands-on digital support. Students from PIC''s Business and IT departments provide live workshops on e-commerce integration, social media marketing, and digital payment systems to help these local heroes thrive in a global market.',
    'Community'
),
(
    'Eco-Innovation Showcase: REPLA-BRICK Sustainable Paving Solutions',
    '/assets/images/latest/repla-brick.png',
    '2026-02-22',
    'This showcase introduces "REPLA-BRICK," a revolutionary student-led initiative focused on transforming plastic waste into high-quality, durable building materials. The project demonstrates the full lifecycle of recycled plastic—from raw waste collection to the compression of sustainable paving blocks. During the event, students presented their data on carbon emission reduction and waste management to faculty and local environmental experts, highlighting PIC''s commitment to "Inovasi Hijau untuk Indonesia".',
    'Environment'
),
(
    'Youth Voices Circle: Forum Diskusi Kesehatan Mental',
    '/assets/images/latest/youth-voices-circle.png',
    '2026-03-08',
    'The Youth Voices Circle is a safe-space initiative designed to promote mental health awareness among the student body. In this session, participants engaged in a "circle talk" format to discuss the pressures of academic life, social media anxiety, and the importance of seeking help. The forum combined a brainstorming session with an open-floor discussion, allowing students to share personal stories and coping mechanisms under the guidance of a professional youth advocate.',
    'Social'
);
