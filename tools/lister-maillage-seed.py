"""Liste, zone par zone, les groupes de liens (titre, type, cibles) écrits dans le seed des zones."""
import re, sys
s = open(sys.argv[1] if len(sys.argv) > 1 else 'bin/seed-fidelite-zones.php', encoding='utf-8').read()
blocs = re.split(r"'post_type' => 'zone', 'name' => '([a-z0-9-]+)'", s)
for i in range(1, len(blocs), 2):
    slug, corps = blocs[i], blocs[i + 1]
    niveau = re.search(r"tfp_seed_set_field\( 'niveau', '([a-z]+)'", corps)
    print(f"== {slug} ({niveau.group(1) if niveau else '?'})")
    for n in range(1, 9):
        t = re.search(rf"'locaux_{n}_titre', '((?:[^'\\]|\\.)*)'", corps)
        if not t or not t.group(1):
            continue
        ty = re.search(rf"'locaux_{n}_type', '([a-z]+)'", corps)
        c = re.search(rf"'locaux_{n}_cibles', (implode\( \"\\n\", array\((.*?)\) \)|'')", corps, re.S)
        cibles = re.findall(r"'([a-z0-9-]+)'", c.group(2)) if c and c.group(2) else []
        print(f"  {n} [{ty.group(1) if ty else '?'}] {t.group(1)} -> {cibles}")
